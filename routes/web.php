<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/profile', [SiteController::class, 'profile'])->name('profile');
Route::get('/produk', [SiteController::class, 'products'])->name('products');
Route::get('/artikel', [SiteController::class, 'articles'])->name('articles');
Route::get('/artikel/{slug}', [SiteController::class, 'article'])->name('article');
Route::get('/galery', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

// Auth user website (terpisah dari login admin Filament di /admin)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/riwayat-pemesanan', [OrderController::class, 'history'])->name('order.history');
    Route::get('/pesan/{product}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/pesan/{product}', [OrderController::class, 'store'])->name('order.store');
});

