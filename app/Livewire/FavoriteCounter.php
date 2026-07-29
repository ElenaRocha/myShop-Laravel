<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FavoriteCounter extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->refreshCount();
    }

    #[On('favorites-updated')]
    public function refreshCount(): void
    {
        $this->count = Auth::check()
            ? Auth::user()->favorites()->count()
            : 0;
    }

    public function render()
    {
        return view('livewire.favorite-counter');
    }
}
