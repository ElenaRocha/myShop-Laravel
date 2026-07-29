<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CartSummary extends Component
{
    #[Computed]
    public function cartTotal(): float
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return 0.0;
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        return $products->sum(fn ($product) => $product->final_price * $cart[$product->id]);
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
