<div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg overflow-hidden product-card border border-transparent dark:border-border {{ $class }} relative {{ $product['offer'] !== null ? 'ring-2 ring-orange-400' : '' }}">
    <!-- Badge de oferta destacado (esquina superior derecha) -->
    @if($product['offer'] !== null)
        <div class="absolute top-0 right-0 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">
                -{{ $product['offer']['discount_percentage'] }}%
            </span>
        </div>
    @endif
    
    <div class="h-48 bg-bg-alt dark:bg-bg-main flex items-center justify-center {{ $product['offer'] !== null ? 'bg-gradient-to-br from-orange-50 to-red-50' : '' }}">
        <span class="text-4xl">📦</span>
    </div>
    <div class="p-6">
        <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">{{ $product['name'] }}</h4>
        <p class="text-text-2 dark:text-text-2 mb-4">{{ $product['description'] }}</p>
        
        <!-- Badge de oferta adicional (nombre de la oferta) -->
        @if($product['offer'] !== null)
            <div class="mb-4">
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-semibold">
                    🏷️ {{ $product['offer']['name'] }}
                    </span>
            </div>
        @endif
        
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div class="flex flex-col">
                <x-price-tag :product="$product" />
            </div>
            <a href="{{ route('products.show', $product['id']) }}" 
               class="bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition">
                {{ __('messages.buttons.view_details') }}
            </a>
        </div>
    </div>
</div>