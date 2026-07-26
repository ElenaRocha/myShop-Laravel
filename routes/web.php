<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===========================================
// RUTAS PÚBLICAS (Sin autenticación requerida)
// ===========================================

// Welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Contacto
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Categorías (solo lectura)
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Favoritos (públicas de momento): las tres rutas pasarán al grupo auth cuando exija sesión
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Productos (solo lectura pública). El CRUD pasa al grupo admin, más abajo.
// on-sale va ANTES del resource para no chocar con products/{product}.
Route::get('/products/on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');
Route::resource('products', ProductController::class)->only(['index', 'show']);

// Marcas
Route::resource('brands', BrandController::class);

// Ofertas (solo index y show)
Route::resource('offers', OfferController::class)->only(['index', 'show']);

// Proveedores (solo index)
Route::resource('suppliers', SupplierController::class)->only(['index']);

// Páginas legales
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
    Route::get('/cookies', [LegalController::class, 'cookies'])->name('cookies');
});

// ===========================================
// RUTAS DE USUARIO AUTENTICADO
// ===========================================

Route::middleware('auth')->group(function () {
    // Dashboard: destino tras el login (config('fortify.home')).
    // Estaba suelta al instalar Fortify; ahora pasa aquí, protegida por el middleware auth.
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

// ===========================================
// RUTAS DE ADMINISTRACIÓN (auth + is_admin)
// ===========================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::resource('products', ProductController::class)->except(['index', 'show']);
});