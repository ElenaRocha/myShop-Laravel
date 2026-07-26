<!-- Header con navegación -->
<header class="bg-bg-soft shadow-lg relative">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('welcome') }}" class="text-2xl font-bold text-brand-300 hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
                    🛍️ {{ config('app.name') }}
                </a>
            </div>

            <!-- Navegación desktop usando partial -->
            @include('partials.navigation')

            <!-- Botones desktop -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="{{ route('favorites.index') }}"
                   class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                    ❤️ {{ __('messages.nav.favorites') }}
                </a>
                @guest
                    <a href="{{ route('login') }}"
                    class="bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition">
                        {{ __('messages.auth.login') }}
                    </a>
                    <a href="{{ route('register') }}"
                    class="border-2 border-brand-300 text-brand-300 dark:border-brand-200 dark:text-brand-200 px-4 py-2 rounded-lg hover:bg-brand-300 hover:text-bg-soft transition">
                        {{ __('messages.auth.register') }}
                    </a>
                @endguest

                @auth
                    <span class="text-text-2">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.products.index') }}"
                        class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">{{ __('messages.nav.admin') }}</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                            {{ __('messages.auth.logout') }}
                        </button>
                    </form>
                @endauth
                <!-- Botón de modo oscuro desktop -->
                <button id="darkModeToggleDesktop" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition p-2 rounded-full">
                    🌙
                </button>
            </div>

            <!-- Botones móvil/tablet -->
            <div class="flex items-center space-x-2 lg:hidden">
                <!-- Botón de modo oscuro -->
                <button id="darkModeToggle" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition p-2 rounded-full dark-mode-toggle">
                    🌙
                </button>
                <!-- Botón menú móvil -->
                <button id="mobileMenuToggle" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menú móvil -->
        <div id="mobileMenu" class="lg:hidden hidden mt-4 pb-4 border-t border-border mobile-menu">
            <nav class="flex flex-col space-y-4 pt-4">
                <a href="{{ route('welcome') }}" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('welcome') ? 'text-brand-300 font-semibold' : '' }}">{{ __('messages.nav.home') }}</a>
                <a href="{{ route('products.index') }}" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('products.*') ? 'text-brand-300 font-semibold' : '' }}">{{ __('messages.nav.products') }}</a>
                <a href="{{ route('categories.index') }}" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('categories.*') ? 'text-brand-300 font-semibold' : '' }}">{{ __('messages.nav.categories') }}</a>
                <a href="{{ route('offers.index') }}" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('offers.*') ? 'text-brand-300 font-semibold' : '' }}">{{ __('messages.nav.offers') }}</a>
                <a href="{{ route('contact') }}" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition {{ request()->routeIs('contact') ? 'text-brand-300 font-semibold' : '' }}">{{ __('messages.nav.contact') }}</a>
                <div class="flex flex-col space-y-2 pt-4 border-t border-border">
                    <a href="{{ route('favorites.index') }}" class="text-left text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                        ❤️ {{ __('messages.nav.favorites') }}
                    </a>
                    @guest
                        <a href="{{ route('login') }}"
                        class="bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition">
                            {{ __('messages.auth.login') }}
                        </a>
                        <a href="{{ route('register') }}"
                        class="border-2 border-brand-300 text-brand-300 dark:border-brand-200 dark:text-brand-200 px-4 py-2 rounded-lg hover:bg-brand-300 hover:text-bg-soft transition">
                            {{ __('messages.auth.register') }}
                        </a>
                    @endguest

                    @auth
                        <span class="text-text-2">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.products.index') }}"
                            class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">{{ __('messages.nav.admin') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                                {{ __('messages.auth.logout') }}
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
</header>