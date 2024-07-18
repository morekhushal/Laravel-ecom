<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('home');
});
Route::match(['GET', 'POST'], 'user-login', [UserController::class, 'login'])->name('user-login');
Route::get('user-home', [UserController::class, 'userHome'])->name('user-home');
Route::get('user-logout', [UserController::class, 'userLogout'])->name('user-logout');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('load-cart', [CartController::class, 'loadCart'])->name('load-cart');
Route::post('update-cart-qty', [CartController::class, 'updateCartQty'])->name('update-cart-qty');
Route::post('remove-cart', [CartController::class, 'removeCart'])->name('remove-cart');
Route::post('place-order', [CartController::class, 'placeOrder'])->name('place-order');
Route::resource('carts', CartController::class);


Route::match(['GET', 'POST'], 'admin-login', [AdminController::class, 'login'])->name('admin-login');
Route::get('admin-home', [AdminController::class, 'adminHome'])->name('admin-home');
Route::get('admin-logout', [AdminController::class, 'adminLogout'])->name('admin-logout');
Route::get('orders', [AdminController::class, 'orders'])->name('orders');
Route::get('load-orders', [AdminController::class, 'loadOrders'])->name('load-orders');
Route::resource('products', ProductController::class);