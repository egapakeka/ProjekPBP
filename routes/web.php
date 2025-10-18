<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\CategoryPublicController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;

use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Pengunjung (Tanpa Login)
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
| User (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Route dashboard yang redirect ke landing
    Route::get('/dashboard', function () {
        return redirect()->route('landing');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/items/{item}', [CartController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{item}', [CartController::class, 'destroy'])->name('cart.items.destroy');

    // Checkout
    Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('checkout.buy-now');
    Route::post('/checkout/summary', [CheckoutController::class, 'summary'])->name('checkout.summary');
    Route::post('/checkout/complete', [CheckoutController::class, 'store'])->name('checkout.store');

    // Orders - Tracking pesanan user
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');

    // Logout paksa (opsional)
    Route::get('/force-logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    })->name('force.logout');
});

/*
|--------------------------------------------------------------------------
| Admin Area (Harus Login & Role Admin)
|--------------------------------------------------------------------------
*/
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

    // Admin Profile
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

});

/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, Forgot Password, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
