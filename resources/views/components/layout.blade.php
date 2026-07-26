@props(['title' => null])
<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head', ['title' => $title])
</head>
<body class="bg-bg-main text-text-1 font-sans">
    <!-- Header usando partial -->
    @include('partials.header')

    <!-- Notificaciones Flash -->
    @include('partials.flash-messages')
    
    <!-- Contenido principal -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>
    
    <!-- Footer usando partial -->
    @include('partials.footer')

    <!-- Scripts por página -->
    @stack('scripts')

    <!-- Scripts globales (modo oscuro y menú móvil) -->
    @include('partials.scripts')
</body>
</html>