<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255|unique:products,name')]
    public string $name = '';

    #[Validate('required|string|max:1000')]
    public string $description = '';

    #[Validate('required|numeric|min:0|max:999999.99')]
    public string $price = '';

    #[Validate('required|exists:categories,id')]
    public string $category_id = '';

    #[Validate('required|integer|min:0')]
    public int $stock = 0;

    #[Validate('nullable|image|mimes:jpeg,png,jpg,webp|max:2048')]
    public ?TemporaryUploadedFile $image = null;

    #[Validate('boolean')]
    public bool $is_active = true;

    public function mount(): void
    {
        abort_if(! Auth::user()?->is_admin, 403);
    }

    public function save(): void
    {
        $validated = $this->validate();

        $validated['slug'] = $this->uniqueSlug($validated['name']);

        $validated['image'] = $this->image
            ? $this->image->store('products', 'public')
            : null;

        Product::create($validated);

        $this->reset();
        $this->dispatch('product-created');
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $suffix = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }
};
?>

<div>
    <form wire:submit="save" class="space-y-6">
        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_name') }} *</label>
            <input type="text" id="name" wire:model="name"
                   class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div>
            <label for="description" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_description') }} *</label>
            <textarea id="description" wire:model="description" rows="4"
                      class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('description') border-red-500 @enderror"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Imagen --}}
        <div>
            <label for="image" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_image') }}</label>
            <input type="file" id="image" wire:model="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="mt-1 block w-full text-sm text-text-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-300 file:text-bg-soft hover:file:bg-brand-400 @error('image') border-red-500 @enderror">
            <p class="mt-1 text-xs text-text-2">{{ __('messages.admin.image_hint') }}</p>
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div wire:loading wire:target="image" class="mt-2 text-xs text-text-2">
                {{ __('messages.buttons.saving') }}
            </div>

            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" alt="{{ __('messages.admin.field_image') }}"
                     class="mt-3 h-32 w-32 object-cover rounded-md shadow-sm">
            @endif
        </div>

        {{-- Precio --}}
        <div>
            <label for="price" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_price') }} *</label>
            <input type="number" id="price" wire:model="price" step="0.01" min="0"
                   class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('price') border-red-500 @enderror">
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Stock --}}
        <div>
            <label for="stock" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_stock') }} *</label>
            <input type="number" id="stock" wire:model="stock" min="0"
                   class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('stock') border-red-500 @enderror">
            @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Categoría --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-text-1">{{ __('messages.admin.col_category') }} *</label>
            <select id="category_id" wire:model="category_id"
                    class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('category_id') border-red-500 @enderror">
                <option value="">{{ __('messages.admin.select_category') }}</option>
                @foreach ($this->categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Activo --}}
        <div>
            <div class="flex items-center">
                <input type="checkbox" id="is_active" wire:model="is_active"
                       class="rounded border-border text-brand-300 focus:ring-brand-300">
                <label for="is_active" class="ml-2 block text-sm text-text-1">{{ __('messages.admin.field_active') }}</label>
            </div>
            @error('is_active')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Enviar --}}
        <div class="flex justify-end pt-4">
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="save"
                class="px-4 py-2 bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main rounded-md hover:bg-brand-400 dark:hover:bg-brand-100 transition disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="save">{{ __('messages.buttons.create_product') }}</span>
                <span wire:loading wire:target="save">{{ __('messages.buttons.saving') }}</span>
            </button>
        </div>
    </form>
</div>
