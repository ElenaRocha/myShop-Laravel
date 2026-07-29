<a href="{{ route('favorites.index') }}"
   class="relative inline-flex items-center text-text-1 hover:text-brand-300 dark:hover:text-brand-200 transition">
    <span class="text-xl">❤️</span>
    <span class="ml-1">{{ __('messages.nav.favorites') }}</span>
    @if($count > 0)
        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold
                      rounded-full w-5 h-5 flex items-center justify-center">
            {{ $count > 99 ? '99+' : $count }}
        </span>
    @endif
</a>