<x-layout :title="__('messages.pages.my_favorites')">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('messages.pages.my_favorites') }}</h1>
            <p class="text-gray-600">{{ __('messages.pages.favorites_subtitle') }}</p>
        </div>
        
        @if(!empty($favoriteItems))
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('messages.products.title') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($favoriteItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item['name'] }}</div>
                                    </td>
                                </tr>
            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    @else
        <div class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ __('messages.favorites.empty') }}</p>
                <a href="{{ route('products.index') }}" 
                   class="mt-4 inline-block bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                    {{ __('messages.buttons.view_products') }}
            </a>
        </div>
    @endif
    </div>
</x-layout>