<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

#[Middleware('token:secret123', only: ['store', 'destroy'])]
class FavoriteController extends Controller
{
    /**
     * Show the favorites overview
     */
    public function index(): View
    {
        // Por ahora, mostramos los favoritos del primer usuario
        // La autenticación se añade cuando el proyecto tenga login de usuarios
        $user = User::first(); // Usuario por defecto (su id es un UUID, no un entero)

        // Productos favoritos con sus datos pivot (incluido price_at_add).
        // Cargamos la oferta y la categoría con with() para que el accessor
        // final_price y $product->category->name no provoquen consultas N+1.
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
        // La lógica real —añadir a la lista del usuario autenticado— llega con la autenticación. Por ahora, redirige con un aviso simulado.
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