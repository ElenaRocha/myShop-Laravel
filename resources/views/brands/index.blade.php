<x-layout :title="__('messages.brands.title')">
    @push('styles')
        <style>
            .product-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 2rem;
            }
        </style>
    @endpush

    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('messages.brands.title') }}</h1>
            <p class="text-gray-600">Descubre las editoriales y casas creativas que acompañan cada lectura.</p>
        </div>

        <div class="product-grid">
            @forelse($brands as $brand)
                <x-brand-card :brand="$brand" />
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No hay editoriales disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
