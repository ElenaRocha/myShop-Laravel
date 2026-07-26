<div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg overflow-hidden product-card border border-transparent dark:border-border {{ $class }} relative {{ $product->offer ? 'ring-2 ring-orange-400' : '' }}">
    <!-- Badge de oferta destacado (esquina superior derecha) -->
    @if($product->offer)
        <div class="absolute top-0 right-0 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">
                -{{ $product->offer->discount_percentage }}%
            </span>
        </div>
    @endif

    <!-- Marcar/desmarcar como favorito (solo usuarios autenticados) -->
    @auth
        @php $isFavorite = auth()->user()->favorites->contains('id', $product->id); @endphp
        <form action="{{ $isFavorite ? route('favorites.destroy', $product) : route('favorites.store', $product) }}"
              method="POST" class="absolute top-0 left-0 z-10">
            @csrf
            @if($isFavorite) @method('DELETE') @endif
            <button type="submit"
                    aria-label="{{ $isFavorite ? __('messages.favorites.remove') : __('messages.buttons.add_favorite') }}"
                    class="m-2 flex h-9 w-9 items-center justify-center rounded-full bg-bg-soft/90 dark:bg-bg-alt/90 shadow hover:scale-110 transition">
                {{ $isFavorite ? '❤️' : '🤍' }}
            </button>
        </form>
    @endauth

    <div class="h-48 bg-bg-alt dark:bg-bg-main flex items-center justify-center overflow-hidden {{ $product->offer ? 'bg-gradient-to-br from-orange-50 to-red-50' : '' }}">
        @if(!empty($product->image))
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover">
        @else
            <span class="text-4xl">📦</span>
        @endif
    </div>

    <div class="p-6">
        <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">{{ $product->name }}</h4>
        <p class="text-text-2 dark:text-text-2 mb-4">{{ $product->description }}</p>

        <!-- Badge de oferta adicional (nombre de la oferta) -->
        @if($product->offer)
            <div class="mb-4">
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-semibold">
                    🏷️ {{ $product->offer->name }}
                </span>
            </div>
        @endif

        <!-- Precio (reutiliza el componente x-price-tag del proyecto) -->
        <div class="mb-4">
            <x-price-tag :product="$product" size="md" />
        </div>

        <a href="{{ route('products.show', $product->id) }}"
           class="block text-center bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition">
            {{ __('messages.buttons.view_details') }}
        </a>
    </div>
</div>