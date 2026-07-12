<x-layout :title="__('messages.pages.all_products')">
    @push('styles')
        <style>
            .product-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 2rem;
            }
        </style>
    @endpush

    <div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('messages.pages.all_products') }}</h1>
        <p class="text-gray-600">{{ __('messages.pages.products_subtitle') }}</p>
    </div>

        <div class="product-grid">
        @forelse($products as $product)
                <x-product-card :product="$product" />
        @empty
            <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">{{ __('messages.empty.products') }}</p>
            </div>
        @endforelse
    </div>
    </div>
</x-layout>