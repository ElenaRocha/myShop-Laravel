<div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg p-6 product-card cursor-pointer border border-transparent dark:border-border {{ $class }}">
    <div class="text-4xl text-brand-200 mb-4">📚</div>
    <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">{{ $brand->name }}</h4>
    <p class="text-text-2 dark:text-text-2 mb-4">{{ $brand->description }}</p>
    <a href="{{ route('brands.show', $brand->id) }}"
       class="text-brand-300 font-semibold hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
        {{ __('messages.buttons.view_details') }}
    </a>
</div>
