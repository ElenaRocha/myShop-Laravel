<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * Show the favorites overview
     */
    public function index(): View
    {
        $user = User::first();

        $favorites = $user->favorites()->with(['offer', 'category'])->get();

        return view('favorites.index', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * Add a product to the favorites list.
     */
    public function store(string $id): RedirectResponse
    {
        return redirect()->route('favorites.index')
            ->with('success', 'Producto añadido a favoritos (simulado)');
    }

    /**
     * Remove a product from the favorites list.
     */
    public function destroy(string $id): RedirectResponse
    {
        return redirect()->route('favorites.index')
            ->with('success', 'Producto eliminado de favoritos (simulado)');
    }
}
