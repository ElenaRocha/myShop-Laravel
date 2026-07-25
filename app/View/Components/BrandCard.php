<?php

namespace App\View\Components;

use App\Models\Brand;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BrandCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Brand $brand,
        public string $class = ''
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.brand-card');
    }
}
