<x-layout :title="__($title)">
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ __($title) }}</h1>
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                <p class="text-gray-700 leading-relaxed">{{ __($body) }}</p>
            </div>
            
            <div class="mt-8">
                <a href="{{ route('welcome') }}" class="text-brand-300 hover:underline">
                    &larr; {{ __('messages.buttons.back_home') }}
                </a>
            </div>
        </div>
    </div>
</x-layout>