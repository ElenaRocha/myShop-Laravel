<x-layout :title="__('messages.hero.title')">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-brand-400 to-brand-300 dark:from-brand-500 dark:to-brand-400 text-bg-soft py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                {{ __('messages.hero.title') }}
            </h2>
            <p class="text-xl md:text-2xl text-bg-alt mb-8 max-w-3xl mx-auto">
                {{ __('messages.hero.subtitle') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index') }}" 
                   class="bg-bg-soft text-brand-300 font-bold py-4 px-8 rounded-full hover:bg-bg-alt transition duration-300 ease-in-out transform hover:scale-105">
                    {{ __('messages.buttons.view_products') }}
                </a>
                <a href="{{ route('products.on-sale') }}" 
                   class="border-2 border-bg-soft text-bg-soft font-bold py-4 px-8 rounded-full hover:bg-bg-soft hover:text-brand-300 transition duration-300 ease-in-out">
                    🏷️ {{ __('messages.buttons.special_offers') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Categorías Destacadas -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-text-1 dark:text-text-1">
                {{ __('messages.sections.categories') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredCategories as $category)
                    <x-category-card :category="$category" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-text-3 text-lg">{{ __('messages.empty.categories') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="py-16 bg-bg-alt dark:bg-bg-main">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-text-1 dark:text-text-1">
                {{ __('messages.sections.featured') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-text-3 text-lg">{{ __('messages.empty.featured') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>