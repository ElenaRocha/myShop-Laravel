<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public string $sort = 'name';

    public bool $onSale = false;

    public function mount(bool $onSale = false): void
    {
        $this->onSale = $onSale;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($this->onSale, fn ($query) => $query->whereNotNull('offer_id'))
            ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->category, fn ($query) => $query->where('category_id', $this->category))
            ->when($this->sort === 'price_asc', fn ($query) => $query->orderBy('price', 'asc'))
            ->when($this->sort === 'price_desc', fn ($query) => $query->orderBy('price', 'desc'))
            ->when($this->sort === 'name', fn ($query) => $query->orderBy('name'))
            ->paginate(12);
    }
};
?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="{{ __('messages.search.placeholder') }}"
            class="w-full rounded-lg border border-border bg-bg-soft dark:bg-bg-alt px-4 py-2 text-text-1 focus:outline-none focus:ring-2 focus:ring-brand-300"
        >

        <select
            wire:model.live="category"
            class="w-full rounded-lg border border-border bg-bg-soft dark:bg-bg-alt px-4 py-2 text-text-1"
        >
            <option value="">{{ __('messages.search.all_categories') }}</option>
            @foreach ($this->categories as $categoryOption)
                <option value="{{ $categoryOption->id }}">{{ $categoryOption->name }}</option>
            @endforeach
        </select>

        <select
            wire:model.live="sort"
            class="w-full rounded-lg border border-border bg-bg-soft dark:bg-bg-alt px-4 py-2 text-text-1"
        >
            <option value="name">{{ __('messages.search.sort_name') }}</option>
            <option value="price_asc">{{ __('messages.search.sort_price_asc') }}</option>
            <option value="price_desc">{{ __('messages.search.sort_price_desc') }}</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($this->products as $product)
            <x-product-card :product="$product" />
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-text-2 text-lg">{{ __('messages.empty.products') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $this->products->links() }}
    </div>
</div>
