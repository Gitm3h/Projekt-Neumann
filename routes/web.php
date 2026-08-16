<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StorageLocationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PasswordChangeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $u = Auth::user();
    if ($u->role === 'kunde')
        return redirect()->route('portal.index');
    if ($u->role === 'kassenkraft')
        return redirect()->route('sales.index');
    if (in_array ($u->role, ['lagermitarbeiter', 'spediteur']))
        return redirect()->route('stock-movements.index');

    $lowStock = \App\Models\Stock::with('article')->get()
        ->filter(fn($s) => $s->quantity < $s->article->min_stock)
        ->count();

    return view('dashboard', ['lowStock' => $lowStock]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'password_changed'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('password-changed', [PasswordChangeController::class, 'edit'])->name('password.force');
    Route::put('password-changed', [PasswordChangeController::class, 'update'])->name('password.force.update');

    Route::middleware('role:kassenkraft,administrator')->group(function () {
        Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/invoices/{sale}', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
        Route::get('z-bericht', [ReportController::class, 'zBericht'])->name('reports.z');
        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::patch('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    });

    Route::middleware('role:lagermitarbeiter,administrator')->group(function () {
        Route::resource('articles', ArticleController::class);
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::resource('storage-locations', StorageLocationController::class);
    });

    Route::middleware('role:lagermitarbeiter,spediteur,administrator')->group(function () {
        Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store','destroy']);
        Route::get('lieferungen', [StockMovementController::class, 'deliveries'])->name('stock-movements.deliveries');
    });

    Route::middleware('role:administrator,kassenkraft,lagermitarbeiter,spediteur')->group(function () {
        Route::get('niedrigbestand', [ReportController::class, 'niedrig'])->name('reports.low-stock');
    });


});

Route::middleware(['auth', 'customer'])
    ->prefix('portal')->name('portal.')
    ->group(function () {
        Route::get('/', [PortalController::class, 'index'])->name('index');
        Route::post('reservieren', [PortalController::class, 'reserve'])
            ->name('reserve');
    });

    Route::middleware('role:administrator')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);
        Route::patch('users/{user}', [UserController::class, 'resetPassword'])->name('users.reset');

});


require __DIR__.'/auth.php';
