<x-layout :title="__('messages.auth.login')">
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-md mx-auto bg-bg-soft rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold text-brand-300 dark:text-brand-200 mb-6">
                {{ __('messages.auth.login') }}
            </h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-text-2 mb-1">{{ __('messages.auth.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2 rounded-lg bg-bg-main text-text-1 border border-border focus:border-brand-300 focus:outline-none">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-text-2 mb-1">{{ __('messages.auth.password') }}</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2 rounded-lg bg-bg-main text-text-1 border border-border focus:border-brand-300 focus:outline-none">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2 text-text-2">
                    <input type="checkbox" name="remember"> {{ __('messages.auth.remember') }}
                </label>

                <button type="submit"
                        class="w-full bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition font-semibold">
                    {{ __('messages.auth.login') }}
                </button>
            </form>

            <button id="login-passkey" type="button" class="w-full border border-brand-300 text-brand-300 px-4 py-2 rounded-lg mt-3">
                {{ __('messages.auth.passkey_continue') }}
            </button>

            <p class="text-text-2 text-sm mt-6 text-center">
                {{ __('messages.auth.no_account') }}
                <a href="{{ route('register') }}" class="text-brand-300 dark:text-brand-200 hover:underline">{{ __('messages.auth.register') }}</a>
            </p>
        </div>
    </div>
</x-layout>