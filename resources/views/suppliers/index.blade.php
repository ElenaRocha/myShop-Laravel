<x-layout :title="__('messages.suppliers.title')">
    <section class="py-12">
        <div class="container mx-auto px-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-text-1 mb-3">{{ __('messages.suppliers.title') }}</h1>
                <p class="text-text-2">{{ __('messages.suppliers.subtitle') }}</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($suppliers as $supplier)
                    <article class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg p-6 border border-transparent dark:border-border">
                        <h2 class="text-xl font-semibold text-text-1 mb-2">{{ $supplier->name }}</h2>
                        <p class="text-text-2">
                            <span class="font-medium">{{ __('messages.suppliers.email') }}:</span>
                            <a href="mailto:{{ $supplier->email }}" class="hover:text-brand-300 dark:hover:text-brand-200 transition">
                                {{ $supplier->email }}
                            </a>
                        </p>

                        <p class="text-text-2 mt-2">
                            <span class="font-medium">{{ __('messages.suppliers.products') }}:</span>
                            {{ $supplier->products->count() }}
                        </p>

                        @if ($supplier->address)
                            <p class="text-text-2 mt-2">
                                <span class="font-medium">{{ __('messages.suppliers.address') }}:</span>
                                {{ $supplier->address->street }} {{ $supplier->address->postal_code }} {{ $supplier->address->city }}
                            </p>
                        @endif

                        @if ($supplier->brands->isNotEmpty())
                            <div class="mt-4">
                                <span class="font-medium text-text-2">{{ __('messages.suppliers.brands') }}:</span>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($supplier->brands as $brand)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-brand-300/10 text-brand-300 dark:bg-brand-200/10 dark:text-brand-200">
                                            {{ $brand->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </article>
                @empty
                    <p class="text-text-3">{{ __('messages.suppliers.empty') }}</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>