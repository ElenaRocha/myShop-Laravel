<x-layout :title="__('messages.dashboard.title')">
    <div class="container mx-auto px-6 py-12">
        @auth
        <div class="max-w-2xl mx-auto space-y-6">

            {{-- Cabecera de perfil --}}
            <div class="bg-bg-soft rounded-lg shadow-lg p-8 flex items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-brand-300 dark:bg-brand-200 text-bg-soft dark:text-bg-main flex items-center justify-center text-3xl font-bold shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-text-1">{{ auth()->user()->name }}</h1>
                    <p class="text-text-2">{{ auth()->user()->email }}</p>
                    <p class="text-text-2 text-sm mt-1">
                        {{ __('messages.dashboard.member_since') }} {{ auth()->user()->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            {{-- Datos de la cuenta --}}
            <div class="bg-bg-soft rounded-lg shadow-lg p-8">
                <h2 class="text-lg font-semibold text-brand-300 dark:text-brand-200 mb-4">{{ __('messages.dashboard.account_data') }}</h2>
                <dl class="divide-y divide-border">
                    <div class="flex justify-between py-3">
                        <dt class="text-text-2">{{ __('messages.auth.name') }}</dt>
                        <dd class="text-text-1 font-medium">{{ auth()->user()->name }}</dd>
                    </div>
                    <div class="flex justify-between py-3">
                        <dt class="text-text-2">{{ __('messages.auth.email') }}</dt>
                        <dd class="text-text-1 font-medium">{{ auth()->user()->email }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-bg-soft rounded-lg shadow-lg p-8">
                <h2 class="text-lg font-semibold text-brand-300 dark:text-brand-200 mb-2">{{ __('messages.dashboard.security') }}</h2>
                <p class="text-text-2 mb-4">{{ __('messages.dashboard.security_hint') }}</p>
            </div>
        </div>
        @else
        <p class="text-center text-text-2">
            <a href="{{ route('login') }}" class="text-brand-300 dark:text-brand-200 hover:underline">{{ __('messages.dashboard.login_required') }}</a>
        </p>
        @endauth
    </div>
</x-layout>