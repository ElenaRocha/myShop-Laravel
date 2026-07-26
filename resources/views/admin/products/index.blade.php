<x-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-brand-300 dark:text-brand-200">
                {{ __('messages.admin.products_title') }}
            </h1>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center shrink-0 whitespace-nowrap bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition font-semibold text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('messages.admin.create_product') }}
            </a>
        </div>

        <div class="bg-bg-soft overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-border">
                        <thead class="bg-bg-main">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_image') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_category') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.products.price') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-text-2 uppercase tracking-wider">{{ __('messages.admin.col_actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-bg-soft divide-y divide-border">
                            @forelse($products as $product)
                                <tr class="hover:bg-bg-main">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="h-16 w-16 object-cover rounded-md shadow-sm">
                                        @else
                                            <div class="h-16 w-16 bg-bg-main flex items-center justify-center rounded-md text-4xl">
                                                📦
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-text-1">{{ $product->name }}</div>
                                        <div class="text-sm text-text-2">{{ Str::limit($product->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-brand-300/20 text-brand-300 dark:text-brand-200">
                                            {{ $product->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-text-1">€{{ number_format($product->price, 2) }}</div>
                                        @if($product->offer)
                                            <div class="text-xs text-orange-600">
                                                {{ __('messages.offers.discount', ['percent' => $product->offer->discount_percentage]) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="text-brand-300 hover:text-brand-400 mr-4">
                                            {{ __('messages.buttons.edit') }}
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" 
                                              method="POST" 
                                              class="inline-block" 
                                              onsubmit="return confirm('{{ __('messages.admin.confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                {{ __('messages.buttons.remove') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
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
    </div>
</x-layout>