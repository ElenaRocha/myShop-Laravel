<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito de compras con los datos de la sesión.
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);

        $productIds = array_keys($cart);

        $cartProducts = Product::with(['category', 'offer'])->find($productIds);

        $cartProducts = $cartProducts->map(function ($product) use ($cart) {
            $product->quantity = $cart[$product->id];
            return $product;
        });

        return view('cart.index', [
            'cartProducts' => $cartProducts
        ]);
    }

    /**
     * Añade un producto al carrito de compras en la sesión.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = $request->input('product_id');
        
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', __('messages.cart.added'));
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = $request->input('quantity');
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', __('messages.cart.updated'));
        }

        return redirect()->route('cart.index')->with('error', __('messages.cart.not_found'));
    }

    /**
     * Elimina un producto del carrito de compras.
     */
    public function destroy(string $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', __('messages.cart.removed'));
        }

        return redirect()->route('cart.index')->with('error', __('messages.cart.not_found'));
    }
    
    /**
     * Simula la finalización de la compra, vaciando el carrito.
     */
    public function checkout(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('welcome')->with('success', __('messages.cart.order_placed'));
    }
}