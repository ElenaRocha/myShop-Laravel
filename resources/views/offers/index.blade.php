<x-layout :title="__('messages.nav.offers')">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-1 mb-4">{{ __('messages.buttons.special_offers') }}</h1>
            <p class="text-text-2">{{ __('messages.pages.offers_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($offers as $offer)
                <div class="bg-bg-soft rounded-lg shadow-lg p-6 border-l-4 border-orange-500">
                    <h3 class="text-xl font-bold text-text-1 mb-2">{{ $offer->name }}</h3>
                    <p class="text-text-2 mb-4">{{ $offer->description }}</p>
                    <div class="text-2xl font-bold text-orange-600 mb-4">
                        {{ __('messages.offers.discount', ['percent' => $offer->discount_percentage]) }}
                    </div>
                    <a href="{{ route('offers.show', $offer->id) }}"
                       class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                        {{ __('messages.buttons.view_products') }}
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-text-2 text-lg">{{ __('messages.empty.offers') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>