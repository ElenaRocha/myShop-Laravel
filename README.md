# MyShop

Librería online especializada en ficción, no ficción, cómic/manga y literatura juvenil e infantil, pensada para lectoras y lectores jóvenes. Catálogo con categorías, ofertas, favoritos por usuario, carrito de compra y panel de administración de productos.

## Stack tecnológico

- **Framework**: Laravel 13 (PHP 8.5)
- **Frontend**: Livewire 4 + Tailwind CSS 4
- **Base de datos**: PostgreSQL 18 (vía Laravel Sail)
- **Autenticación**: Laravel Fortify (incluye passkeys y 2FA)
- **Tests**: Pest 4 + PHPUnit
- **Calidad**: Pint (PSR-12), PHPStan/Larastan nivel 5

## Requisitos

- Docker (para [Laravel Sail](https://laravel.com/docs/sail))
- Node.js (para compilar los assets con Vite)

## Instalación

```bash
git clone https://github.com/ElenaRocha/myShop-Laravel.git
cd myShop-Laravel
cp .env.example .env

# Instala las dependencias de Composer sin tener PHP local
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php85-composer:latest \
    composer install --ignore-platform-reqs

./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

La aplicación queda disponible en `http://localhost`.

## Comandos habituales

```bash
sail artisan test --compact      # Tests (Pest)
sail bin pint                    # Formateo de código
sail php vendor/bin/phpstan analyse   # Análisis estático
sail npm run dev                 # Vite en modo desarrollo
```

## Arquitectura

Para un índice detallado de rutas, controladores, modelos, vistas y seeders, consulta [docs/CODEBASE.md](docs/CODEBASE.md).
