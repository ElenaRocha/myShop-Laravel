<x-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-text-1 mb-8">{{ __('messages.admin.create_product') }}</h1>

        <div class="bg-bg-soft p-6 rounded-lg shadow-sm">
            <livewire:admin.create-product-form />
        </div>
    </div>
</x-layout>