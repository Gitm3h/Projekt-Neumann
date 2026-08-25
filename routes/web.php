<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CategoryController;
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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PickupController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $u = Auth::user();
    if ($u->role === 'kunde')
        return redirect()->route('portal.index');

    $lowStock = \App\Models\Stock::with('article')->get()
        ->filter(fn($s) => $s->quantity < $s->article->min_stock)
        ->count();

    $reservierungen = \App\Models\Reservation::where('status', 'reserviert')->count();

    return view('dashboard', ['lowStock' => $lowStock, 'reservierungen' => $reservierungen]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'password_changed'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/customer', [ProfileController::class, 'updateCustomer'])->name('profile.customer.update');

    Route::get('password-changed', [PasswordChangeController::class, 'edit'])->name('password.force');
    Route::put('password-changed', [PasswordChangeController::class, 'update'])->name('password.force.update');

    Route::middleware('role:kassenkraft,administrator')->group(function () {
        Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/invoices/{sale}', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
        Route::get('z-bericht', [ReportController::class, 'zBericht'])->name('reports.z');
        Route::get('z-bericht/pdf', [ReportController::class, 'zBerichtPdf'])->name('reports.z.pdf');


        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::patch('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        Route::resource('customers', CustomerController::class);
        Route::patch('customers/{customer}/password-reset', [CustomerController::class, 'resetPassword'])->name('customers.reset');
        Route::get('inventory', [ArticleController::class, 'stock'])->name('articles.stock');
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::patch('invoices/{invoice}/bezahlt', [InvoiceController::class, 'markPaid'])->name('invoices.paid');
        Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    });

    Route::middleware('role:lagermitarbeiter,administrator')->group(function () {
        Route::resource('articles', ArticleController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::resource('storage-locations', StorageLocationController::class);
        Route::resource('stock-movements', StockMovementController::class)->only(['index', 'destroy']);
        Route::get('abholungen/anlegen', [PickupController::class, 'create'])->name('pickups.create');
        Route::post('abholungen', [PickupController::class, 'store'])->name('pickups.store');
        Route::get('abholungen/verwalten', [PickupController::class, 'manage'])->name('pickups.manage');
        Route::patch('abholungen/{pickup}/zuweisen', [PickupController::class, 'update'])->name('pickups.update');
        Route::get('abholungen/{pickup}/bearbeiten', [PickupController::class, 'edit'])->name('pickups.edit');
    });

    Route::middleware('role:lagermitarbeiter,spediteur,administrator')->group(function () {
        Route::get('stock-movements/create', [StockMovementController::class, 'create'])->name('stock-movements.create');
        Route::post('stock-movements', [StockMovementController::class, 'store'])->name('stock-movements.store');
    });

    Route::middleware('role:administrator,kassenkraft,lagermitarbeiter')->group(function () {
        Route::get('niedrigbestand', [ReportController::class, 'niedrig'])->name('reports.low-stock');
    });

    Route::middleware('role:spediteur,administrator')->group(function () {
        Route::get('lieferungen', [StockMovementController::class, 'deliveries'])->name('stock-movements.deliveries');
        Route::get('abholungen', [PickupController::class, 'index'])->name('pickups.index');
        Route::patch('abholungen/{pickup}', [PickupController::class, 'confirm'])->name('pickups.confirm');
    });


});

Route::middleware(['auth', 'customer', 'password_changed'])
    ->prefix('portal')->name('portal.')
    ->group(function () {
        Route::get('/', [PortalController::class, 'index'])->name('index');
        Route::get('articles', [PortalController::class, 'articles'])->name('articles');
        Route::get('reservations', [PortalController::class, 'reservations'])->name('reservations');
        Route::post('reservieren', [PortalController::class, 'reserve'])
            ->name('reserve');
        Route::patch('reservations/{reservation}/stornieren', [PortalController::class, 'cancel'])
            ->name('reservations.cancel');
        Route::patch('reservation-items/{item}', [PortalController::class, 'updateItem'])
            ->name('items.update');
        Route::patch('profile/customer', [ProfileController::class, 'updateCustomer'])
            ->name('profile.customer.update');
    });

    Route::middleware('role:administrator')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);
        Route::patch('users/{user}/password-reset', [UserController::class, 'resetPassword'])->name('users.reset');

});


require __DIR__.'/auth.php';
