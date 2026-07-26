<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Contact page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Favorites routes
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Special route for products on sale
Route::get('/products/on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');

// Resource routes
Route::resource('products', ProductController::class);

// OfferController
Route::resource('offers', OfferController::class)->only(['index', 'show']);

// Brand routes
Route::resource('brands', BrandController::class);

// Supplier routes
Route::resource('suppliers', SupplierController::class);

// Legal section routes
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
    Route::get('/cookies', [LegalController::class, 'cookies'])->name('cookies');
});

Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
