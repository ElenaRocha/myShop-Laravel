<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Online</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-bg-main text-text-1 font-sans">
    <!-- Header con navegación -->
    <header class="bg-bg-soft shadow-lg relative">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-2xl font-bold text-brand-300 hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">🛍️ Mi Tienda</a>
                </div>
                
                <!-- Navegación desktop -->
                <nav class="hidden lg:flex space-x-8">
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Inicio</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Productos</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Categorías</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Ofertas</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Contacto</a>
                </nav>
                
                <!-- Botones desktop -->
                <div class="hidden lg:flex items-center space-x-4">
                    <button class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                        ❤️ Favoritos (0)
                    </button>
                    <button class="bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition">
                        Iniciar Sesión
                    </button>
                    <button class="border-2 border-brand-300 text-brand-300 dark:border-brand-200 dark:text-brand-200 px-4 py-2 rounded-lg hover:bg-brand-300 hover:text-bg-soft dark:hover:bg-brand-200 dark:hover:text-bg-main transition">
                        Registrarse
                    </button>
                    <!-- Botón de modo oscuro desktop -->
                    <button id="darkModeToggleDesktop" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition p-2 rounded-full">
                        🌙
                    </button>
                </div>
                
                <!-- Botones móvil/tablet -->
                <div class="flex items-center space-x-2 lg:hidden">
                    <!-- Botón de modo oscuro -->
                    <button id="darkModeToggle" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition p-2 rounded-full dark-mode-toggle">
                        🌙
                    </button>
                    <!-- Botón menú móvil -->
                    <button id="mobileMenuToggle" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
                <!-- Menú móvil -->
                <div id="mobileMenu" class="lg:hidden hidden mt-4 pb-4 border-t border-border mobile-menu">
                <nav class="flex flex-col space-y-4 pt-4">
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Inicio</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Productos</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Categorías</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Ofertas</a>
                    <a href="#" class="text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">Contacto</a>
                    <div class="flex flex-col space-y-2 pt-4 border-t border-border">
                        <button class="text-left text-text-2 dark:text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">
                            ❤️ Favoritos (0)
                        </button>
                        <button class="bg-brand-300 text-bg-soft dark:bg-brand-200 dark:text-bg-main px-4 py-2 rounded-lg hover:bg-brand-400 dark:hover:bg-brand-100 transition text-left">
                            Iniciar Sesión
                        </button>
                        <button class="border-2 border-brand-300 text-brand-300 dark:border-brand-200 dark:text-brand-200 px-4 py-2 rounded-lg hover:bg-brand-300 hover:text-bg-soft dark:hover:bg-brand-200 dark:hover:text-bg-main transition text-left">
                            Registrarse
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-brand-400 to-brand-300 dark:from-brand-500 dark:to-brand-400 text-bg-soft py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Bienvenido a Mi Tienda
            </h2>
            <p class="text-xl md:text-2xl text-bg-alt mb-8 max-w-3xl mx-auto">
                Descubre una amplia variedad de productos de calidad. 
                Encuentra lo que buscas al mejor precio.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="bg-bg-soft text-brand-300 font-bold py-4 px-8 rounded-full hover:bg-bg-alt transition duration-300 ease-in-out transform hover:scale-105">
                    Ver Productos
                </button>
                <button class="border-2 border-bg-soft text-bg-soft font-bold py-4 px-8 rounded-full hover:bg-bg-soft hover:text-brand-300 transition duration-300 ease-in-out">
                    Ofertas Especiales
                </button>
            </div>
        </div>
    </section>

    <!-- Categorías de Productos -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-text-1 dark:text-text-1">
                Nuestras Categorías
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg p-6 product-card cursor-pointer">
                    <div class="text-4xl text-brand-200 mb-4">📦</div>
                    <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Categoría 1</h4>
                    <p class="text-text-2 dark:text-text-2 mb-4">
                        Descripción de la primera categoría de productos.
                    </p>
                    <button class="text-brand-300 font-semibold hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
                        Ver Productos →
                    </button>
                </div>

                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg p-6 product-card cursor-pointer">
                    <div class="text-4xl text-brand-200 mb-4">🛍️</div>
                    <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Categoría 2</h4>
                    <p class="text-text-2 dark:text-text-2 mb-4">
                        Descripción de la segunda categoría de productos.
                    </p>
                    <button class="text-brand-300 font-semibold hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
                        Ver Productos →
                    </button>
                </div>

                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg p-6 product-card cursor-pointer">
                    <div class="text-4xl text-brand-200 mb-4">⭐</div>
                    <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Categoría 3</h4>
                    <p class="text-text-2 dark:text-text-2 mb-4">
                        Descripción de la tercera categoría de productos.
                    </p>
                    <button class="text-brand-300 font-semibold hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
                        Ver Productos →
                    </button>
                </div>

                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg p-6 product-card cursor-pointer">
                    <div class="text-4xl text-brand-200 mb-4">🎯</div>
                    <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Categoría 4</h4>
                    <p class="text-text-2 dark:text-text-2 mb-4">
                        Descripción de la cuarta categoría de productos.
                    </p>
                    <button class="text-brand-300 font-semibold hover:text-brand-400 dark:text-brand-200 dark:hover:text-brand-100 transition">
                        Ver Productos →
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="py-16 bg-bg-alt dark:bg-bg-main">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-text-1 dark:text-text-1">
                Productos Destacados
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg overflow-hidden product-card border border-transparent dark:border-border">
                    <div class="h-48 bg-bg-alt dark:bg-bg-main flex items-center justify-center">
                        <span class="text-4xl">📦</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Producto 1</h4>
                        <p class="text-text-2 dark:text-text-2 mb-4">Descripción del primer producto</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-brand-300 dark:text-brand-200">€XX</span>
                            <button class="bg-brand-300 text-bg-soft px-4 py-2 rounded-lg hover:bg-brand-400 dark:bg-brand-200 dark:text-bg-main dark:hover:bg-brand-100 transition">
                                Añadir a Favoritos
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg overflow-hidden product-card border border-transparent dark:border-border">
                    <div class="h-48 bg-bg-alt dark:bg-bg-main flex items-center justify-center">
                        <span class="text-4xl">🛍️</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Producto 2</h4>
                        <p class="text-text-2 dark:text-text-2 mb-4">Descripción del segundo producto</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-brand-300 dark:text-brand-200">€XX</span>
                            <button class="bg-brand-300 text-bg-soft px-4 py-2 rounded-lg hover:bg-brand-400 dark:bg-brand-200 dark:text-bg-main dark:hover:bg-brand-100 transition">
                                Añadir a Favoritos
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-bg-soft dark:bg-bg-alt rounded-lg shadow-lg overflow-hidden product-card border border-transparent dark:border-border">
                    <div class="h-48 bg-bg-alt dark:bg-bg-main flex items-center justify-center">
                        <span class="text-4xl">⭐</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 text-text-1 dark:text-text-1">Producto 3</h4>
                        <p class="text-text-2 dark:text-text-2 mb-4">Descripción del tercer producto</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-brand-300 dark:text-brand-200">€XX</span>
                            <button class="bg-brand-300 text-bg-soft px-4 py-2 rounded-lg hover:bg-brand-400 dark:bg-brand-200 dark:text-bg-main dark:hover:bg-brand-100 transition">
                                Añadir a Favoritos
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-bg-main dark:bg-bg-alt text-text-1 py-12 border-t border-border">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">🛍️ Mi Tienda</h5>
                    <p class="text-text-2">
                        Tu tienda de confianza para encontrar los mejores productos.
                    </p>
                </div>
                <div>
                    <h6 class="font-bold mb-4">Enlaces Rápidos</h6>
                    <ul class="space-y-2 text-text-2">
                        <li><a href="#" class="hover:text-brand-300 dark:hover:text-brand-200 transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="hover:text-brand-300 dark:hover:text-brand-200 transition">Política de Privacidad</a></li>
                        <li><a href="#" class="hover:text-brand-300 dark:hover:text-brand-200 transition">Términos y Condiciones</a></li>
                        <li><a href="#" class="hover:text-brand-300 dark:hover:text-brand-200 transition">Envíos y Devoluciones</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold mb-4">Atención al Cliente</h6>
                    <ul class="space-y-2 text-text-2">
                        <li>📞 Teléfono de contacto</li>
                        <li>📧 Email de contacto</li>
                        <li>💬 Chat en vivo</li>
                        <li>🕒 Horario de atención</li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold mb-4">Síguenos</h6>
                    <div class="flex space-x-4">
                        <a href="#" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">📘 Facebook</a>
                        <a href="#" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">📷 Instagram</a>
                        <a href="#" class="text-text-2 hover:text-brand-300 dark:hover:text-brand-200 transition">🐦 Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-border mt-8 pt-8 text-center text-text-3">
                <p>&copy; 2025-2026 Mi Tienda. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle dark mode functionality
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
            
            // Cambiar el icono según el modo para ambos botones
            const toggleButton = document.getElementById('darkModeToggle');
            const toggleButtonDesktop = document.getElementById('darkModeToggleDesktop');
            
            if (document.documentElement.classList.contains('dark')) {
                if (toggleButton) toggleButton.innerHTML = '☀️';
                if (toggleButtonDesktop) toggleButtonDesktop.innerHTML = '☀️';
            } else {
                if (toggleButton) toggleButton.innerHTML = '🌙';
                if (toggleButtonDesktop) toggleButtonDesktop.innerHTML = '🌙';
            }
        }

        // Toggle mobile menu functionality
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const menuToggle = document.getElementById('mobileMenuToggle');
            
            mobileMenu.classList.toggle('hidden');
            
            // Cambiar el icono del botón
            if (mobileMenu.classList.contains('hidden')) {
                menuToggle.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            } else {
                menuToggle.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
            }
        }

        // Check for saved dark mode preference
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
                const toggleButton = document.getElementById('darkModeToggle');
                const toggleButtonDesktop = document.getElementById('darkModeToggleDesktop');
                if (toggleButton) toggleButton.innerHTML = '☀️';
                if (toggleButtonDesktop) toggleButtonDesktop.innerHTML = '☀️';
            }
            
            // Configurar los botones
            const toggleButton = document.getElementById('darkModeToggle');
            const toggleButtonDesktop = document.getElementById('darkModeToggleDesktop');
            if (toggleButton) toggleButton.onclick = toggleDarkMode;
            if (toggleButtonDesktop) toggleButtonDesktop.onclick = toggleDarkMode;
            document.getElementById('mobileMenuToggle').onclick = toggleMobileMenu;
        });
    </script>
</body>