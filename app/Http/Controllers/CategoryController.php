<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use LoadsMockData;

    /**
     * Show all categories
     */
    public function index(): View
    {
        $categories = $this->getCategories();
        
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show products from a specific category
     */
    public function show(string $category): View
    {
        $categories = $this->getCategories();
        
        // Find category by ID (devuelve null si la clave no existe)
        $categoryId = $category;
        $category = $categories[$categoryId] ?? null;
        
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }
        
        // Load and enrich products
        $products = $this->getProducts();
        
        // Filter products by category
        $categoryProducts = array_filter($products, function($product) use ($categoryId) {
            return $product['category_id'] == $categoryId;
        });

        $categoryProducts = $this->enrichProductsWithOffers($categoryProducts);
        
        return view('categories.show', compact('category', 'categoryProducts'));
    }
}