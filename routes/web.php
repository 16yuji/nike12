<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    CartController,
    CheckoutController,
    OrderController
};
use App\Http\Controllers\Admin\{
    ProductAdminController,
    UserAdminController,
    OrderAdminController
};

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalog
Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class,'show'])->name('products.show');

// Cart
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class,'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');

// Orders (customer) – cần đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

// Admin – chỉ admin mới vào
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Quản lý Sản phẩm
        Route::resource('products', ProductAdminController::class);

        // Quản lý Người dùng
        Route::resource('users', UserAdminController::class)->except(['show']);

        // Quản lý Đơn hàng
        Route::get('orders', [OrderAdminController::class,'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderAdminController::class,'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderAdminController::class,'updateStatus'])->name('orders.updateStatus');
        Route::delete('orders/{order}', [OrderAdminController::class,'destroy'])->name('orders.destroy');
    });

// Breeze auth routes
require __DIR__.'/auth.php';
