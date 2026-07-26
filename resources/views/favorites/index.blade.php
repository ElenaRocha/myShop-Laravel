<x-layout :title="__('messages.nav.favorites')">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-1 mb-4">{{ __('messages.pages.my_favorites') }}</h1>
            <p class="text-text-2">{{ __('messages.pages.favorites_subtitle') }}</p>
        </div>

        @if($favorites->isEmpty())
            <div class="text-center py-12">
                <p class="text-text-2 text-lg">{{ __('messages.favorites.empty') }}</p>
                <a href="{{ route('products.index') }}"
                   class="mt-4 inline-block bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                    {{ __('messages.buttons.view_products') }}
                </a>
            </div>
        @else
            <div class="bg-bg-soft rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border">
                        <thead class="bg-bg-main">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">
                                    {{ __('messages.products.product') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">Precio actual</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">Precio al añadir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">Variación</th>
                            </tr>
                        </thead>
                        <tbody class="bg-bg-soft divide-y divide-border">
                            @foreach($favorites as $product)
                                @php
                                    $snapshot = (float) $product->pivot->price_at_add;
                                    $pct = $snapshot > 0
                                        ? round(($product->final_price - $snapshot) / $snapshot * 100, 1)
                                        : null;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-text-1">{{ $product->name }}</div>
                                        <div class="text-sm text-text-2">{{ $product->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-text-1">
                                        €{{ number_format($product->final_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-1">
                                        @if($product->pivot->price_at_add !== null)
                                            €{{ number_format($snapshot, 2) }}
                                        @else
                                            <span class="text-text-2">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                        @if($pct === null)
                                            <span class="text-text-2">—</span>
                                        @elseif($pct < 0)
                                            <span class="text-green-600">▼ Ha bajado un {{ abs($pct) }}%</span>
                                        @elseif($pct > 0)
                                            <span class="text-red-600">▲ Ha subido un {{ $pct }}%</span>
                                        @else
                                            <span class="text-text-2">Sin cambios</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layout>