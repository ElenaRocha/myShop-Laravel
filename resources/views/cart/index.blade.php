<x-layout :title="__('messages.cart.title')">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">🛒 {{ __('messages.cart.title') }}</h1>

    @if($cartProducts->isEmpty())
        <div class="bg-bg-soft rounded-lg shadow-lg p-8 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-text-1 mb-2">{{ __('messages.cart.empty') }}</h2>
            <p class="text-text-2 mb-6">{{ __('messages.cart.empty_hint') }}</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-brand-300 text-white px-6 py-3 rounded-lg hover:bg-brand-400 transition">
                {{ __('messages.buttons.view_products') }}
            </a>
        </div>
    @else
        <div class="bg-bg-soft rounded-lg shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-bg-main">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-text-1">{{ __('messages.products.product') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-text-1">{{ __('messages.products.price') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-text-1">{{ __('messages.cart.quantity') }}</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-text-1">{{ __('messages.cart.subtotal') }}</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-text-1">{{ __('messages.cart.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($cartProducts as $product)
                        @php
                            $subtotal = $product->final_price * $product->quantity;
                        @endphp
                        
                        <tr class="hover:bg-bg-main">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-16 w-16 object-cover rounded-md mr-4">
                                    @else
                                        <div class="h-16 w-16 bg-bg-main flex items-center justify-center rounded-md text-4xl mr-4">
                                            📚
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-text-1">{{ $product->name }}</div>
                                        <div class="text-sm text-text-2">{{ $product->category->name }}</div>
                                        @if($product->offer)
                                            <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full mt-1">
                                                🏷️ -{{ $product->offer->discount_percentage }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->offer)
                                    <div>
                                        <span class="text-sm text-text-2 line-through">€{{ number_format($product->price, 2) }}</span>
                                        <div class="font-semibold text-orange-600">€{{ number_format($product->final_price, 2) }}</div>
                                    </div>
                                @else
                                    <div class="font-semibold text-text-1">€{{ number_format($product->final_price, 2) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{-- FORMULARIO PARA ACTUALIZAR CANTIDAD --}}
                                <form action="{{ route('cart.update', $product->id) }}" method="POST" class="flex items-center justify-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" class="w-20 text-center border-border rounded-md shadow-sm">
                                    <button type="submit" class="ml-2 p-1 text-brand-300 hover:text-brand-400" title="{{ __('messages.cart.update_qty') }}">🔄</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 font-semibold text-text-1">€{{ number_format($subtotal, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                {{-- FORMULARIO PARA ELIMINAR --}}
                                <form action="{{ route('cart.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="{{ __('messages.buttons.remove') }}">🗑️ {{ __('messages.buttons.remove') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-bg-main">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-right">
                            <livewire:cart-summary />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="bg-bg-main text-text-1 px-6 py-3 rounded-lg hover:bg-bg-main transition">
                ← {{ __('messages.cart.keep_shopping') }}
            </a>
            {{-- FORMULARIO PARA FINALIZAR COMPRA --}}
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-success text-white font-bold px-6 py-3 rounded-lg hover:opacity-90 transition">
                    {{ __('messages.buttons.checkout') }} →
                </button>
            </form>
        </div>
    @endif
</div>
</x-layout>