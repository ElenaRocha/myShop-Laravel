<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Show all categories
     */
    public function index(): View
    {
        $categories = Category::all();
        
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show products from a specific category
     */
    public function show(Category $category): View
    {
        $categoryProducts = $category->products()->with(['offer'])->get();

        return view('categories.show', compact('category', 'categoryProducts'));
    }
}