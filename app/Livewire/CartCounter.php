<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->refreshCount();
    }

    #[On('cart-updated')]
    public function refreshCount(): void
    {
        $cart = session()->get('cart', []);
        $this->count = array_sum($cart);
    }

    public function render(): View
    {
        return view('livewire.cart-counter');
    }
}