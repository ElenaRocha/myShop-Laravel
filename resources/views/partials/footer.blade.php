    <!-- Footer -->
    <footer class="bg-bg-main dark:bg-bg-alt text-text-1 py-12 border-t border-border">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">🛍️ {{ config('app.name') }}</h5>
                    <p class="text-text-2">
                        {{ __('messages.footer.tagline') }}
                    </p>
                </div>
                <div>
                    <h6 class="font-bold mb-4">Legal</h6>
                    <ul class="space-y-2 text-text-2">
                        <li>
                            <a href="{{ route('legal.privacy') }}" class="hover:text-brand-300 dark:hover:text-brand-200 transition">
                                {{ __('messages.privacy.title') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('legal.terms') }}" class="hover:text-brand-300 dark:hover:text-brand-200 transition">
                                {{ __('messages.terms.title') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('legal.cookies') }}" class="hover:text-brand-300 dark:hover:text-brand-200 transition">
                                {{ __('messages.cookies.title') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold mb-4">{{ __('messages.footer.support') }}</h6>
                    <ul class="space-y-2 text-text-2">
                        <li>📞 Teléfono de contacto</li>
                        <li>📧 Email de contacto</li>
                        <li>💬 Chat en vivo</li>
                        <li>🕒 Horario de atención</li>
                        <li><a href="{{ route('contact') }}" class="hover:text-brand-300 dark:hover:text-brand-200 transition">{{ __('messages.nav.contact') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold mb-4">{{ __('messages.footer.follow') }}</h6>
                    <div class="flex space-x-4">
                        <a href="#" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">📘 Facebook</a>
                        <a href="#" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">📷 Instagram</a>
                        <a href="#" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">🐦 Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-border mt-8 pt-8 text-center text-text-3">
                <p>&copy; 2025-2026 {{ config('app.name') }}. {{ __('messages.footer.rights') }}</p>
            </div>
        </div>
    </footer>