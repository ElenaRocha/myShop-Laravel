<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * Show the favorites overview for the authenticated user.
     */
    public function index(): View
    {
        $favorites = auth()->user()->favorites()->with(['offer', 'category'])->get();

        return view('favorites.index', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * Add a product to the authenticated user's favorites list.
     */
    public function store(Product $product): RedirectResponse
    {
        $user = auth()->user();

        if (! $user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->attach($product->id, [
                'price_at_add' => $product->final_price,
            ]);
        }

        return redirect()->back()->with('success', __('messages.favorites.added'));
    }

    /**
     * Remove a product from the authenticated user's favorites list.
     */
    public function destroy(Product $product): RedirectResponse
    {
        auth()->user()->favorites()->detach($product->id);

        return redirect()->back()->with('success', __('messages.favorites.removed'));
    }
}
