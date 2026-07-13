<x-layout :title="$product['name']">
    <div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Imagen del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="h-96 bg-gray-200 flex items-center justify-center">
                    <span class="text-8xl">📦</span>
            </div>
        </div>

        <!-- Información del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product['name'] }}</h1>
                <p class="text-gray-600 mb-6">{{ $product['description'] }}</p>
            
            <!-- Precio -->
            <div class="mb-6">
                <x-price-tag :product="$product" />
                @if($product['offer'] !== null)
                    <p class="text-sm text-orange-600 mt-2">
                        {{ __('messages.products.save', ['amount' => '€' . number_format($product['price'] - $product['final_price'], 2)]) }}
                    </p>
                @endif
            </div>
            
                <!-- Categoría -->
                @if(isset($category))
            <div class="mb-6">
                        <span class="text-sm text-gray-500">{{ __('messages.products.category') }}</span>
                        <a href="{{ route('categories.show', $category['id']) }}" 
                           class="ml-2 bg-brand-100 text-brand-500 px-3 py-1 rounded-full text-sm hover:bg-brand-200 transition">
                            {{ $category['name'] }}
                        </a>
            </div>
                @endif
            
                <!-- Oferta -->
                @if($product['offer'] !== null)
            <div class="mb-6">
                        <span class="text-sm text-gray-500">{{ __('messages.products.active_offer') }}</span>
                        <div class="mt-2">
                                    <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">
                                        🏷️ {{ $product['offer']['name'] }} (-{{ $product['offer']['discount_percentage'] }}%)
                        </span>
                </div>
            </div>
                        @endif
                
                <!-- Botones de Acción -->
            <div class="flex space-x-4">
                    {{-- En esta sesión los favoritos son solo de lectura (mock fijo): el enlace
                         lleva a la lista. Más adelante, con sesión/BD, este botón escribirá. --}}
                    <a href="{{ route('favorites.index') }}"
                       class="bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                        ❤️ {{ __('messages.buttons.add_favorite') }}
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="border border-brand-300 text-brand-300 px-6 py-3 rounded-lg hover:bg-brand-100 transition">
                        ← {{ __('messages.buttons.back_products') }}
                    </a>
            </div>
        </div>
    </div>
    </div>
</x-layout>