<button wire:click="toggle"
        title="{{ $inFavorites ? 'Quitar de favoritos' : 'Añadir a favoritos' }}"
        class="text-2xl leading-none transition hover:scale-110">
    {{ $inFavorites ? '❤️' : '🤍' }}
</button>