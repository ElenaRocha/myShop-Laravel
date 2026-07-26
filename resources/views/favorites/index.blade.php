<x-layout :title="__('messages.nav.favorites')">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('messages.pages.my_favorites') }}</h1>
            <p class="text-gray-600">{{ __('messages.pages.favorites_subtitle') }}</p>
        </div>

        @if($favorites->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ __('messages.favorites.empty') }}</p>
                <a href="{{ route('products.index') }}"
                   class="mt-4 inline-block bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                    {{ __('messages.buttons.view_products') }}
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('messages.products.product') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.favorites.current_price') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.favorites.price_at_add') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.favorites.variation') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.cart.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($favorites as $product)
                                @php
                                    $snapshot = (float) $product->pivot->price_at_add;
                                    $pct = $snapshot > 0
                                        ? round(($product->final_price - $snapshot) / $snapshot * 100, 1)
                                        : null;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        €{{ number_format($product->final_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @if($product->pivot->price_at_add !== null)
                                            €{{ number_format($snapshot, 2) }}
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                        @if($pct === null)
                                            <span class="text-gray-400">—</span>
                                        @elseif($pct < 0)
                                            <span class="text-green-600">{{ __('messages.favorites.decreased', ['percent' => abs($pct)]) }}</span>
                                        @elseif($pct > 0)
                                            <span class="text-red-600">{{ __('messages.favorites.increased', ['percent' => $pct]) }}</span>
                                        @else
                                            <span class="text-gray-500">{{ __('messages.favorites.no_changes') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('favorites.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="{{ __('messages.favorites.remove') }}">
                                                🗑️ {{ __('messages.buttons.remove') }}
                                            </button>
                                        </form>
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