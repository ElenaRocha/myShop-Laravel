<x-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        <h1 class="text-2xl font-bold text-brand-300 dark:text-brand-200 mb-6">
            {{ __('messages.admin.edit_product') }}
        </h1>
        <div class="bg-bg-soft overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-bg-soft border-b border-border">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nombre del Producto --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_name') }} *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label for="slug" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_slug') }}</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('slug') border-red-500 @enderror">
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_description') }} *</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('description') border-red-500 @enderror" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Imagen del Producto --}}
                        <div>
                            <label for="image" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_image') }}</label>
                            @if ($product->image)
                                <div class="my-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ __('messages.admin.current_image') }}" class="max-h-40 w-auto object-contain rounded-md border border-border">
                                    <p class="text-xs text-text-2 mt-1">{{ __('messages.admin.current_image_hint') }}</p>
                                </div>
                            @endif
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-text-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-300 file:text-bg-soft hover:file:bg-brand-400 @error('image') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-text-2">{{ __('messages.admin.image_hint') }}</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Precio --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_price') }} *</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('price') border-red-500 @enderror" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div>
                            <label for="stock" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_stock') }} *</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('stock') border-red-500 @enderror" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-text-1">{{ __('messages.admin.col_category') }} *</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('category_id') border-red-500 @enderror" required>
                                <option value="">{{ __('messages.admin.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Oferta (Opcional) --}}
                        <div>
                            <label for="offer_id" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_offer') }}</label>
                            <select id="offer_id" name="offer_id" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('offer_id') border-red-500 @enderror">
                                <option value="">{{ __('messages.admin.no_offer') }}</option>
                                @foreach($offers as $offer)
                                    <option value="{{ $offer->id }}" {{ old('offer_id', $product->offer_id) == $offer->id ? 'selected' : '' }}>
                                        {{ $offer->name }} (-{{ $offer->discount_percentage }}%)
                                    </option>
                                @endforeach
                            </select>
                            @error('offer_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Proveedor (Opcional) --}}
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-text-1">{{ __('messages.admin.field_supplier') }}</label>
                            <select id="supplier_id" name="supplier_id" class="mt-1 block w-full rounded-md border-border shadow-sm focus:border-brand-300 focus:outline-none @error('supplier_id') border-red-500 @enderror">
                                <option value="">{{ __('messages.admin.no_supplier') }}</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Producto activo (visible en la tienda) --}}
                        <div>
                            <label class="inline-flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-border text-brand-300 shadow-sm focus:ring focus:ring-brand-200">
                                <span class="ms-2 text-sm text-text-1">{{ __('messages.admin.field_active') }}</span>
                            </label>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-border text-text-2 rounded-md hover:bg-bg-main transition">
                                {{ __('messages.buttons.cancel') }}
                            </a>
                            <button type="submit" class="px-4 py-2 bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main rounded-md hover:bg-brand-400 dark:hover:bg-brand-100 transition">
                                {{ __('messages.buttons.update_product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-layout>