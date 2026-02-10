<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentikasi
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('home.admin');
    Route::get('/admin/category-coffee', [AdminController::class, 'category'])->name('category.page');

    // CRUD Category 
    Route::get('/admin/category/create', [CategoryController::class, 'createCategory'])->name('category.create');
    Route::post('/admin/category', [CategoryController::class, 'storeCategory'])->name('category.store');
    Route::get('/admin/category/{id}/edit', [CategoryController::class, 'editCategory'])->name('category.edit');
    Route::put('/admin/category/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'destroyCategory'])->name('category.destroy');

    Route::get('/admin/product', [AdminController::class, 'product'])->name('product.page');

    // CRUD Product
    Route::get('/admin/products/create', [ProductController::class, 'createProduct'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'storeProduct'])->name('products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'editProduct'])->name('products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/admin/user-orders', [AdminController::class, 'order'])->name('order.page');
});

// Customer
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/customer/home', [CustomerController::class, 'index'])->name('home.customer');

    Route::get('/customer/order', [OrderController::class, 'showProducts'])->name('customer.order');
    Route::post('/customer/order/add', [OrderController::class, 'addToCart'])->name('customer.addToCart');
    Route::get('/customer/blog', [CustomerController::class, 'blog'])->name('customer.blog');
    Route::get('/customer/cart', [OrderController::class, 'showCart'])->name('customer.cart');
    Route::post('/customer/cart/remove', [OrderController::class, 'removeFromCart'])->name('customer.cart.remove');
    Route::post('/customer/cart/update', [OrderController::class, 'updateCart'])->name('customer.cart.update');
    Route::post('/customer/checkout', [OrderController::class, 'checkout'])->name('customer.checkout');
    
    // Payment
    Route::get('/customer/payment/{order_id}', [PaymentController::class, 'showPaymentForm'])->name('customer.payment');
    Route::post('/customer/payment/process', [PaymentController::class, 'processPayment'])->name('customer.payment.process');

    // Order History
    Route::get('/customer/history', [OrderController::class, 'orderHistory'])->name('customer.history');
    Route::get('/customer/history/{id}', [OrderController::class, 'orderDetail'])->name('customer.order.detail');

    // Profile
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
});