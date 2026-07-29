<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $editingId = null;

    #[Validate('required|string|max:255')]
    public string $editName = '';

    public function mount(): void
    {
        abort_if(! Auth::user()?->is_admin, 403);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function startEdit(string $productId): void
    {
        $product = Product::findOrFail($productId);

        $this->editingId = $productId;
        $this->editName = $product->name;
    }

    public function saveEdit(): void
    {
        $this->validate();

        Product::findOrFail($this->editingId)->update(['name' => $this->editName]);

        $this->editingId = null;
        $this->editName = '';
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editName = '';
        $this->resetValidation();
    }

    public function toggleActive(string $productId): void
    {
        $product = Product::findOrFail($productId);

        $product->update(['is_active' => ! $product->is_active]);
    }

    public function delete(string $productId): void
    {
        $product = Product::findOrFail($productId);
        $imagePath = $product->image;

        $product->delete();

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    #[On('product-created')]
    public function handleProductCreated(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->with('category')
            ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->latest()
            ->paginate(10);
    }
};
?>

<div>
    <div class="mb-6">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="{{ __('messages.search.placeholder') }}"
            class="w-full max-w-sm rounded-lg border border-border bg-bg-soft dark:bg-bg-alt px-4 py-2 text-text-1 focus:outline-none focus:ring-2 focus:ring-brand-300"
        >
    </div>

    <div class="bg-bg-soft overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-border">
                <thead class="bg-bg-main">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_category') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_price') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_stock') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-bg-soft divide-y divide-border">
                    @forelse ($this->products as $product)
                        <tr wire:key="product-{{ $product->id }}" class="hover:bg-bg-main">
                            <td class="px-6 py-4">
                                @if ($editingId === $product->id)
                                    <input
                                        type="text"
                                        wire:model="editName"
                                        class="w-full rounded-lg border border-border bg-bg-soft dark:bg-bg-alt px-3 py-1.5 text-text-1 focus:outline-none focus:ring-2 focus:ring-brand-300"
                                    >
                                    @error('editName')
                                        <p class="text-xs text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                @else
                                    <div class="text-sm font-medium text-text-1">{{ $product->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-brand-300/20 text-brand-300 dark:text-brand-200">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-1">
                                €{{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-1">
                                {{ $product->stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-success/20 text-success' : 'bg-danger/20 text-danger' }}">
                                    {{ $product->is_active ? __('messages.admin.status_active') : __('messages.admin.status_inactive') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                @if ($editingId === $product->id)
                                    <button type="button" wire:click="saveEdit" class="text-brand-300 hover:text-brand-400">
                                        {{ __('messages.buttons.save') }}
                                    </button>
                                    <button type="button" wire:click="cancelEdit" class="text-text-2 hover:text-text-1">
                                        {{ __('messages.buttons.cancel') }}
                                    </button>
                                @else
                                    <button type="button" wire:click="startEdit('{{ $product->id }}')" class="text-brand-300 hover:text-brand-400">
                                        {{ __('messages.buttons.edit') }}
                                    </button>
                                    <button type="button" wire:click="toggleActive('{{ $product->id }}')" class="text-text-2 hover:text-text-1">
                                        {{ $product->is_active ? __('messages.buttons.deactivate') : __('messages.buttons.activate') }}
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="delete('{{ $product->id }}')"
                                        wire:confirm="{{ __('messages.admin.confirm_delete') }}"
                                        class="text-danger hover:opacity-75"
                                    >
                                        {{ __('messages.buttons.remove') }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-text-2 text-4xl mb-4">📦</div>
                                <p class="text-text-2 text-lg font-medium">{{ __('messages.admin.no_products') }}</p>
                                <p class="text-text-2 text-sm mt-2">{{ __('messages.admin.no_products_hint') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $this->products->links() }}
    </div>
</div>
