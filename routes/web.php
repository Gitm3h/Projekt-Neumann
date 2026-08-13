<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StorageLocationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $lowStock = \App\Models\Stock::with('article')->get()
        ->filter(fn($s) => $s->quantity < $s->article->min_stock)
        ->count();

    return view('dashboard', ['lowStock' => $lowStock]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   // Route::resource('articles', ArticleController::class);
   // Route::get('stock', [StockController::class, 'index'])->name('stock.index');
    Route::resource('storage-locations', StorageLocationController::class);
    // Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
   // Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
   // Route::post('sales', [SaleController::class, 'store'])->name('sales.store');

   // Route::get('/invoices/{sale}', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
   // Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::middleware('role:kassenkraft,administrator')->group(function () {
        Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/invoices/{sale}', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    });

    Route::middleware('role:lagermitarbeiter,spediteur,administrator')->group(function () {
        Route::resource('articles', ArticleController::class);
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::resource('storage-locations', StorageLocationController::class);
        Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store', 'destroy']);
    });

    Route::middleware('role:administrator')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);
    });
});

require __DIR__.'/auth.php';
