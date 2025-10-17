<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\CategoryPublicController;

use Illuminate\Support\Facades\Auth;


// Landing page
Route::get('/', function () {
    return view('landing');
});

//user biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/landing', function () {
        return view('landing'); // pastikan file ada di resources/views/landing.blade.php
    })->name('landing');
});

/*
|--------------------------------------------------------------------------
| Pengunjung (tanpa login)
|--------------------------------------------------------------------------
*/
// Produk
Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductCatalogController::class, 'show'])->name('products.show');

// Kategori
Route::get('/categories', [CategoryPublicController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryPublicController::class, 'show'])->name('categories.show');

// Halaman statis
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/help', 'pages.help')->name('help');
Route::view('/about', 'pages.about')->name('about');

/*
|--------------------------------------------------------------------------
| User Biasa (harus login)
|--------------------------------------------------------------------------
*/


Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Area (tanpa login & tanpa role check)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // CRUD Kategori & Produk
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Vouchers
    Route::resource('vouchers', VoucherController::class);

    // Deliveries (Atur Pengiriman)
    Route::resource('deliveries', DeliveryController::class);

    // Admin Profile
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';
