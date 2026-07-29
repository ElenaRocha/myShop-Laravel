<x-layout :title="__('messages.sections.categories')">
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-1 mb-4">{{ __('messages.sections.categories') }}</h1>
            <p class="text-text-2">{{ __('messages.pages.categories_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <x-category-card :category="$category" />
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-text-2 text-lg">{{ __('messages.empty.categories') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
