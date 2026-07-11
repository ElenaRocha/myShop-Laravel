<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    use LoadsMockData;

    /**
     * Show the favorites list
     */
    public function index(): View
    {
        $favorites = $this->getFavorites();
        $products = $this->getProducts();

        // Resolve each favorite's product name from the products mock
        $favoriteItems = [];
        foreach ($favorites as $item) {
            $product = $products[$item['product_id']] ?? null;
            $favoriteItems[] = array_merge($item, [
                'name' => $product ? $product['name'] : 'Producto no encontrado'
            ]);
        }

        return view('favorites.index', [
            'favoriteItems' => $favoriteItems
        ]);
    }

    /**
     * Add a product to the favorites list
     */
    public function store(string $id): RedirectResponse
    {
        // En una aplicación real, aquí se añadiría el producto a los favoritos del usuario.
        // Por ahora, solo redirigimos a la lista de favoritos.
        return redirect()->route('favorites.index')
            ->with('success', 'Producto añadido a favoritos (simulado)');
    }

    /**
     * Remove a product from the favorites list
     */
    public function destroy(string $id): RedirectResponse
    {
        // En una aplicación real, aquí se quitaría el producto de los favoritos del usuario.
        // Por ahora, solo redirigimos a la lista de favoritos.
        return redirect()->route('favorites.index')
            ->with('success', 'Producto eliminado de favoritos (simulado)');
    }
}