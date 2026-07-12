<nav class="hidden lg:flex space-x-8">
    <a href="{{ route('welcome') }}" 
       class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('welcome') ? 'text-brand-300 font-semibold' : '' }}">
        {{ __('messages.nav.home') }}
    </a>
    <a href="{{ route('products.index') }}" 
       class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('products.*') ? 'text-brand-300 font-semibold' : '' }}">
        {{ __('messages.nav.products') }}
    </a>
    <a href="{{ route('categories.index') }}" 
       class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('categories.*') ? 'text-brand-300 font-semibold' : '' }}">
        {{ __('messages.nav.categories') }}
    </a>
    <a href="{{ route('offers.index') }}" 
       class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('offers.*') ? 'text-brand-300 font-semibold' : '' }}">
        {{ __('messages.nav.offers') }}
    </a>
    <a href="{{ route('contact') }}" 
       class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('contact') ? 'text-brand-300 font-semibold' : '' }}">
        {{ __('messages.nav.contact') }}
    </a>
</nav>