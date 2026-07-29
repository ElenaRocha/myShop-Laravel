<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Embeddings;
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

    public bool $semanticMode = false;

    public ?string $semanticNotice = null;

    public ?array $queryEmbedding = null;

    public function mount(bool $onSale = false): void
    {
        $this->onSale = $onSale;
    }

    public function updatedSearch(): void
    {
        $this->prepareSemanticSearch();
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

    public function toggleSemanticMode(): void
    {
        $this->semanticMode = ! $this->semanticMode;
        $this->prepareSemanticSearch();
        $this->resetPage();
    }

    private function prepareSemanticSearch(): void
    {
        $this->semanticNotice = null;
        $this->queryEmbedding = null;

        if (! $this->semanticMode) {
            return;
        }

        if (strlen(trim($this->search)) < 3) {
            $this->semanticNotice = __('messages.search.semantic_min_chars');

            return;
        }

        try {
            $this->queryEmbedding = Embeddings::for([$this->search])->dimensions(1536)->generate()->first();
        } catch (Throwable $e) {
            Log::warning('Búsqueda semántica no disponible: '.$e->getMessage());
            $this->semanticNotice = __('messages.search.semantic_unavailable');
        }
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    #[Computed]
    public function products(): LengthAwarePaginator
    {
        if ($this->semanticMode && $this->queryEmbedding !== null) {
            return $this->baseQuery()
                ->whereVectorSimilarTo('embedding', $this->queryEmbedding, minSimilarity: 0.5)
                ->paginate(12);
        }

        return $this->classicSearch();
    }

    private function classicSearch(): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->sort === 'price_asc', fn ($query) => $query->orderBy('price', 'asc'))
            ->when($this->sort === 'price_desc', fn ($query) => $query->orderBy('price', 'desc'))
            ->when($this->sort === 'name', fn ($query) => $query->orderBy('name'))
            ->paginate(12);
    }

    private function baseQuery()
    {
        return Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($this->onSale, fn ($query) => $query->whereNotNull('offer_id'))
            ->when($this->category, fn ($query) => $query->where('category_id', $this->category));
    }
};
?>

<div>
    <div class="flex items-center justify-end mb-3">
        <button
            type="button"
            wire:click="toggleSemanticMode"
            title="{{ $semanticMode ? __('messages.search.semantic_toggle_on') : __('messages.search.semantic_toggle_off') }}"
            class="px-3 py-2 rounded-lg text-sm font-medium transition {{ $semanticMode ? 'bg-purple-600 text-white shadow-md' : 'bg-bg-alt text-text-2 hover:bg-bg-main' }}"
        >
            {{ $semanticMode ? __('messages.search.semantic_label_on') : __('messages.search.semantic_label_off') }}
        </button>
    </div>

    @if ($semanticMode)
        <p class="text-xs text-purple-600 mb-3">
            {{ __('messages.search.semantic_active_notice') }}
        </p>
    @endif

    @if ($semanticNotice)
        <p class="text-xs text-amber-600 mb-3">
            ⚠️ {{ $semanticNotice }}
        </p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="{{ $semanticMode ? __('messages.search.semantic_placeholder') : __('messages.search.placeholder') }}"
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
