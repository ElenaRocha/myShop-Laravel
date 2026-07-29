<x-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-brand-300 dark:text-brand-200">
                {{ __('messages.admin.products_title') }}
            </h1>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center shrink-0 whitespace-nowrap bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition font-semibold text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('messages.admin.create_product') }}
            </a>
        </div>
        <livewire:admin.product-table />
    </div>
</x-layout>