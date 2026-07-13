<x-layout title="Proveedores">
    @push('styles')
        <style>
            .supplier-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 2rem;
            }
        </style>
    @endpush

    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Proveedores</h1>
            <p class="text-gray-600">Explora la red de colaboradores que apoyan la librería.</p>
        </div>

        <div class="supplier-grid">
            @forelse($suppliers as $supplier)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $supplier['name'] }}</h2>
                        <p class="text-gray-600 mb-4">{{ $supplier['contact_person'] }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ $supplier['email'] }}</p>
                        <p class="text-sm text-gray-500 mb-6">{{ $supplier['phone'] }}</p>
                        <a href="{{ route('suppliers.show', $supplier['id']) }}"
                           class="inline-flex items-center text-brand-300 font-medium hover:text-brand-400 transition">
                            Ver detalles
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No hay proveedores disponibles en este momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
