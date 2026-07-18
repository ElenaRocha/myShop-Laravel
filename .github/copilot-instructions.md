# Instrucciones para GitHub Copilot — Proyecto MyShop

## Stack tecnológico
- **Framework**: Laravel 13 (PHP 8.5)
- **Frontend**: Livewire 4 + Tailwind CSS
- **Base de datos**: PostgreSQL 18 (via Laravel Sail)
- **Tests**: Pest + PHPUnit
- **Calidad**: Pint, PHPStan nivel 5, PSR-12

## Entorno de desarrollo
- Todos los comandos CLI usan el prefijo `sail` (ej: `sail artisan migrate`)
- La aplicación corre en `http://localhost`

## Convenciones del código
- Validación siempre en FormRequest (`app/Http/Requests/`), nunca inline en el controlador
- Mensajes de error de validación en español
- Type hints en todos los métodos públicos
- Definir las rutas con `Route::resource` en `routes/web.php`
- Formatear con `sail php vendor/bin/pint` antes de cada commit

## Patrones del proyecto
- Los controladores siguen el patrón resource (index, show, create, store, edit, update, destroy)
- Las vistas Blade usan el layout en `resources/views/layouts/app.blade.php`
- Los componentes Blade están en `resources/views/components/`
- `HasUuids` (UUID); `Category` 1-N `Product`, `Offer` 1-N `Product`, `User` N-M `Product`

## Sobre la tienda
- La tienda es una librería online especializada en ficción, no ficción, cómic y literatura juvenil.
- Está enfocada a lectores jóvenes, predominantemente mujeres.
- Quiero utilizar un tono cercano y entusiasta. Evitar el lenguaje corporativo frío, pero que sí demuestre conocimiento profundo (citar tropos literarios, estilos, o emociones que evoca el libro). Mezcla autoridad con empatía para crear un efecto de "librero de confianza".