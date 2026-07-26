<x-layout :title="__('messages.auth.register')">
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-md mx-auto bg-bg-soft rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold text-brand-300 dark:text-brand-200 mb-6">
                {{ __('messages.auth.register') }}
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-text-2 mb-1">{{ __('messages.auth.name') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2 rounded-lg bg-bg-main text-text-1 border border-border focus:border-brand-300 focus:outline-none">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-text-2 mb-1">{{ __('messages.auth.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 rounded-lg bg-bg-main text-text-1 border border-border focus:border-brand-300 focus:outline-none">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-text-2 mb-1">{{ __('messages.auth.password') }}</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2 rounded-lg bg-bg-main text-text-1 border border-border focus:border-brand-300 focus:outline-none">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-text-2 mb-1">{{ __('messages.auth.password_confirm') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 rounded-lg bg-bg-main text-text-1 border border-border focus:border-brand-300 focus:outline-none">
                </div>

                <button type="submit"
                        class="w-full bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition font-semibold">
                    {{ __('messages.auth.register') }}
                </button>
            </form>

            <p class="text-text-2 text-sm mt-6 text-center">
                {{ __('messages.auth.has_account') }}
                <a href="{{ route('login') }}" class="text-brand-300 dark:text-brand-200 hover:underline">{{ __('messages.auth.login') }}</a>
            </p>
        </div>
    </div>
</x-layout>