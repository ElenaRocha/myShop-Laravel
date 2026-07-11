<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page - shows home page with featured content
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Favorites routes (index es lectura; store/destroy son escritura → se protegen en la FASE 6)
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Special route for products on sale (must be BEFORE resource routes to avoid conflicts:
// /products/on-sale iría capturada por products/{product} si se declara después del resource)
Route::get('/products/on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');

// Resource routes - Example with products (creates all CRUD routes automatically)
Route::resource('products', ProductController::class);

// OfferController: only index y show
Route::resource('offers', OfferController::class)->only(['index', 'show']);