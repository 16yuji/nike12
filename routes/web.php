<?php

use Illuminate\Support\Facades\Route;

// Front (khách hàng)
use App\Http\Controllers\{
    HomeController,
    ProductController as FrontProductController,
    CartController,
    CheckoutController,
    OrderController,
    AccountController
};

// Admin
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

// Danh mục & sản phẩm (Front)
Route::get('/products', [FrontProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [FrontProductController::class, 'show'])->name('products.show');

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
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Tài khoản người dùng
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'is_admin']) // thêm is_admin nếu đã có middleware
    ->group(function () {

        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Sản phẩm (Admin) — BẬT đầy đủ 7 action, có cả show
        Route::resource('products', AdminProductController::class);

        // Người dùng
        Route::resource('users', UserAdminController::class)->except(['show']);

        // Đơn hàng
        Route::get('orders', [OrderAdminController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('orders/{order}', [OrderAdminController::class, 'destroy'])->name('orders.destroy');
    });

/*
|--------------------------------------------------------------------------
| Auth scaffolding (Breeze/Fortify/Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
