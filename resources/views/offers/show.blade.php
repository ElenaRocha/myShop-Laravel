<x-layout :title="$offer->name">
    <div class="container mx-auto px-6 py-8">
        <!-- Header de la Oferta -->
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $offer->name }}</h1>
                    <p class="text-xl">{{ $offer->description }}</p>
                </div>
                <div class="bg-bg-soft text-orange-600 rounded-full w-32 h-32 flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-4xl font-bold">{{ $offer->discount_percentage }}%</div>
                        <div class="text-sm">{{ __('messages.offers.off') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos con esta oferta -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-text-1 mb-6">{{ __('messages.pages.on_sale') }}</h2>

            @if($offerProducts->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($offerProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-bg-main rounded-lg">
                    <p class="text-text-2 text-lg">{{ __('messages.empty.offer_products') }}</p>
                </div>
            @endif
        </div>

        <!-- Botón volver -->
        <div class="mt-8">
            <a href="{{ route('offers.index') }}"
               class="inline-block bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                ← {{ __('messages.buttons.back_offers') }}
            </a>
        </div>
    </div>
</x-layout>