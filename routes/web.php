<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('landing');
});

// Product Catalog Routes (accessible by visitors and users)
Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductCatalogController::class, 'show'])->name('products.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
});



require __DIR__.'/auth.php';
