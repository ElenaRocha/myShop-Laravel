@props(['product'])

@if($product['offer'] !== null)
    <div class="flex flex-col gap-1">
        <div class="flex items-baseline gap-3">
            <span class="text-sm text-text-3 dark:text-text-3 line-through">€{{ number_format($product['price'], 2, ',', '.') }}</span>
            <span class="text-2xl font-bold text-orange-600">€{{ number_format($product['final_price'], 2, ',', '.') }}</span>
        </div>
    </div>
@else
    <span class="text-2xl font-bold text-brand-300 dark:text-brand-200">€{{ number_format($product['price'], 2, ',', '.') }}</span>
@endif