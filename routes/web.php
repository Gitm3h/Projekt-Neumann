<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StorageLocationController;

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
    Route::resource('articles', ArticleController::class);
    Route::get('stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('storage-locations', [StorageLocationController::class, 'index'])->name('storage-locations.index');
});

require __DIR__.'/auth.php';
