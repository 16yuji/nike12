<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    CartController,
    CheckoutController,
    OrderController,
    Admin\ProductAdminController
};

// Public routes
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

// Orders (require auth)
Route::middleware(['auth'])->group(function(){
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
});

// Admin (require admin gate)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
    Route::resource('products', ProductAdminController::class);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Breeze auth routes
require __DIR__.'/auth.php';
