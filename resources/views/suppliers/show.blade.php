<x-layout title="{{ $supplier['name'] }}">
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $supplier['name'] }}</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-700 mb-2"><strong>Persona de contacto:</strong> {{ $supplier['contact_person'] }}</p>
            <p class="text-gray-700 mb-2"><strong>Email:</strong> {{ $supplier['email'] }}</p>
            <p class="text-gray-700"><strong>Teléfono:</strong> {{ $supplier['phone'] }}</p>
        </div>

        <a href="{{ route('suppliers.index') }}" class="inline-block mt-6 text-brand-300 hover:underline">
            ← Volver a proveedores
        </a>
    </div>
</x-layout>
