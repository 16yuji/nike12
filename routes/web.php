<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    CartController,
    CheckoutController,
    OrderController,
    AccountController // <-- thêm controller tài khoản người dùng
};
use App\Http\Controllers\Admin\{
    ProductController as AdminProductController,
    UserAdminController,
    OrderAdminController
};

/*
|--------------------------------------------------------------------------
| Public routes (khách/ai cũng xem được)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Danh mục & sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Giỏ hàng
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'add')->name('cart.add');
    Route::post('/cart/update', 'update')->name('cart.update');
    Route::delete('/cart/items/{item}', 'remove')->name('cart.remove');
});

// Thanh toán
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

/*
|--------------------------------------------------------------------------
| Authenticated customer routes (người dùng đã đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Đơn hàng của tôi
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Dashboard (nếu có dùng)
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Tài khoản người dùng: xem & cập nhật hồ sơ + đổi mật khẩu
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});

/*
|--------------------------------------------------------------------------
| Admin routes (UI riêng cho admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // Trang tổng quan admin
        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Quản lý Sản phẩm
        Route::resource('products', AdminProductController::class);

        // Quản lý Người dùng
        Route::resource('users', UserAdminController::class)->except(['show']);

        // Quản lý Đơn hàng
        Route::get('orders', [OrderAdminController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('orders/{order}', [OrderAdminController::class, 'destroy'])->name('orders.destroy');
    });

/*
|--------------------------------------------------------------------------
| Auth scaffolding (nếu dùng Laravel Breeze/Fortify/Jetstream)
|--------------------------------------------------------------------------
|
| Giữ dòng dưới đây nếu dự án của bạn dùng Breeze/Fortify để có route
| đăng nhập/đăng ký/mật khẩu... Mặc định Breeze tạo file routes/auth.php
|
*/
require __DIR__.'/auth.php';
