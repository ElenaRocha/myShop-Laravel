<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteButton extends Component
{
    public string $productId = '';

    public bool $inFavorites = false;

    public function mount(string $productId): void
    {
        $this->productId = $productId;

        if (Auth::check()) {
            $this->inFavorites = Auth::user()->favorites()
                ->where('product_id', $productId)->exists();
        }
    }

    public function toggle(): void
    {
        if (! Auth::check()) {
            return;
        }

        $user = Auth::user();

        if ($this->inFavorites) {
            $user->favorites()->detach($this->productId);
            $this->inFavorites = false;
        } else {
            $product = Product::findOrFail($this->productId);
            $user->favorites()->attach($this->productId, [
                'price_at_add' => $product->final_price,
            ]);
            $this->inFavorites = true;
        }

        $this->dispatch('favorites-updated');
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
