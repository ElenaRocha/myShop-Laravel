<x-layout :title="$category->name">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-1 mb-4">{{ $category->name }}</h1>
            <p class="text-text-2 mb-4">{{ $category->description }}</p>
            <a href="{{ route('categories.index') }}"
               class="text-brand-300 hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
                ← {{ __('messages.buttons.back_categories') }}
            </a>
        </div>

        @if($categoryProducts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categoryProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-text-2 text-lg">{{ __('messages.empty.category_products') }}</p>
            </div>
        @endif
    </div>
</x-layout>