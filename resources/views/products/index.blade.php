<x-layout :title="__('messages.pages.all_products')">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-1 mb-4">{{ __('messages.pages.all_products') }}</h1>
            <p class="text-text-2">{{ __('messages.pages.products_subtitle') }}</p>
        </div>

        <livewire:product-search :on-sale="$onSale ?? false" />
    </div>
</x-layout>
