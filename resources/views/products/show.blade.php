<x-layout :title="$product->name">
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="h-96 bg-gray-200 flex items-center justify-center overflow-hidden rounded-md">
                    @if(!empty($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain">
                    @else
                        <span class="text-8xl">📦</span>
                    @endif
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-6">{{ $product->description }}</p>
            
                <!-- Precio -->
                <div class="mb-6">
                    <x-price-tag :product="$product" />
                    @if($product->offer)
                        <p class="text-sm text-orange-600 mt-2">
                            {{ __('messages.products.save', ['amount' => '€'.number_format($product->price - $product->final_price, 2)]) }}
                        </p>
                    @endif
                </div>

                <!-- Categoría -->
                @if($product->category)
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">{{ __('messages.products.category') }}</span>
                        <a href="{{ route('categories.show', $product->category->id) }}"
                           class="ml-2 bg-brand-100 text-brand-500 px-3 py-1 rounded-full text-sm hover:bg-brand-200 transition">
                            {{ $product->category->name }}
                        </a>
                    </div>
                @endif

                <!-- Oferta -->
                @if($product->offer)
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">{{ __('messages.products.active_offer') }}</span>
                        <div class="mt-2">
                            <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">
                                🏷️ {{ $product->offer->name }} (-{{ $product->offer->discount_percentage }}%)
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Botones de Acción -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                            🛒 {{ __('messages.buttons.add_to_cart') }}
                        </button>
                    </form>
                    <livewire:favorite-button :product-id="$product->id" />
                    <a href="{{ route('products.index') }}"
                    class="border border-border text-text-1 px-6 py-3 rounded-lg hover:bg-bg-main transition">
                        ← {{ __('messages.buttons.back_products') }}
                    </a>
                </div>

                <!-- Acciones de administrador -->
                <div class="flex items-center space-x-4 mt-4">
                    @can('update', $product)
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="border border-border text-text-1 px-6 py-3 rounded-lg hover:bg-bg-main transition">
                            ✏️ {{ __('messages.buttons.edit') }}
                        </a>
                    @endcan
                    @can('delete', $product)
                        <form action="{{ route('admin.products.destroy', $product) }}"
                              method="POST"
                              onsubmit="return confirm('{{ __('messages.admin.confirm_delete') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                                🗑️ {{ __('messages.buttons.remove') }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-layout>