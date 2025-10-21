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
    ProductController as AdminProductController,
    UserAdminController,
    OrderAdminController
};

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
// Cart Routes
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'add')->name('cart.add');
    Route::post('/cart/update', 'update')->name('cart.update');
    Route::delete('/cart/items/{item}', 'remove')->name('cart.remove');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

/*
|--------------------------------------------------------------------------
| Authenticated customer routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin routes (separate UI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // Dashboard giao diện riêng
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
| Breeze / auth scaffolding
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
