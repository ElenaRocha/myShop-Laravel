<laravel-boost-guidelines>
=== .ai/sobre-la-tienda rules ===

# MyShop

Este proyecto ya tiene instrucciones dirigidas a GitHub Copilot en [.github/copilot-instructions.md](.github/copilot-instructions.md). Este archivo las resume para que se apliquen también en Claude Code. Ante cualquier duda o cambio, esa es la fuente original — mantenerla sincronizada con este archivo si una de las dos cambia.

## Stack tecnológico

- Framework: Laravel 13 (PHP 8.5)
- Frontend: Livewire 4 + Tailwind CSS
- Base de datos: PostgreSQL 18 (via Laravel Sail)
- Tests: Pest + PHPUnit
- Calidad: Pint, PHPStan nivel 5, PSR-12

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

### Nota sobre datos

El proyecto ya migró a Eloquent + PostgreSQL (ver modelos en `app/Models/` y controladores como `ProductController`, que usan `Product::with(...)->get()`). El trait `App\Traits\LoadsMockData` y los ficheros `database/data/mock-*.php` siguen presentes y son la convención que sigue `.github/prompts/make-controller.prompt.md` para generar controladores nuevos — se usa tal cual ese prompt indica, aunque contradiga el patrón real actual, salvo que se pida lo contrario.

## Sobre la tienda

- La tienda es una librería online especializada en ficción, no ficción, cómic y literatura juvenil.
- Está enfocada a lectores jóvenes, predominantemente mujeres.
- Tono cercano y entusiasta. Evitar el lenguaje corporativo frío, pero que sí demuestre conocimiento profundo (citar tropos literarios, estilos, o emociones que evoca el libro). Mezcla autoridad con empatía para crear un efecto de "librero de confianza".

## Recetas reutilizables (`.github/prompts/`)

Estos ficheros son prompts pensados para Copilot pero sirven de receta/checklist cuando se pida una tarea equivalente:
- `make-controller.prompt.md` — generar un controller resource nuevo siguiendo `ProductController` + `LoadsMockData`.
- `make-view.prompt.md` — generar una vista Blade nueva siguiendo `products/index.blade.php`.
- `translate-lang.prompt.md` — traducir `lang/es/messages.php` a otro idioma.
- `sync-codebase.prompt.md` — sincronizar `docs/CODEBASE.md` con el estado del repo.

## Livewire 4: reglas de sintaxis (NO Livewire 2/3)

### Propiedades: siempre tipadas

public string $name = '';   // CORRECTO
public $name;               // INCORRECTO

### Validación: #[Validate] (nunca arrays)

#[Validate('required|string|max:255')]
public string $name = '';   // CORRECTO
protected $rules = [...];    // INCORRECTO
// Reglas dinámicas (Rule::unique, condicionales) → método rules()

### Computed: #[Computed]

#[Computed] public function products(): Collection { ... }  // CORRECTO; en vista: $this->products
public function getProductsProperty() { }                   // INCORRECTO; en vista: $products

### Eventos: #[On] + dispatch()

#[On('cart-updated')] public function refresh(): void { }   // CORRECTO
$this->dispatch('cart-updated');
protected $listeners = [...];  $this->emit('cart-updated');  // INCORRECTO

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- laravel/ai (AI) - v0
- laravel/fortify (FORTIFY) - v1
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v4
- larastan/larastan (LARASTAN) - v3
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- laravel/telescope (TELESCOPE) - v5
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `vendor/bin/sail npm run build`, `vendor/bin/sail npm run dev`, or `vendor/bin/sail composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `vendor/bin/sail artisan route:list`). Use `vendor/bin/sail artisan list` to discover available commands and `vendor/bin/sail artisan [command] --help` to check parameters.
- Inspect routes with `vendor/bin/sail artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `vendor/bin/sail artisan config:show app.name`, `vendor/bin/sail artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `vendor/bin/sail artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `vendor/bin/sail artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== sail rules ===

# Laravel Sail

- This project runs inside Laravel Sail's Docker containers. You MUST execute all commands through Sail.
- Start services using `vendor/bin/sail up -d` and stop them with `vendor/bin/sail stop`.
- Open the application in the browser by running `vendor/bin/sail open`.
- Always prefix PHP, Artisan, Composer, and Node commands with `vendor/bin/sail`. Examples:
    - Run Artisan Commands: `vendor/bin/sail artisan migrate`
    - Install Composer packages: `vendor/bin/sail composer install`
    - Execute Node commands: `vendor/bin/sail npm run dev`
    - Execute PHP scripts: `vendor/bin/sail php [script]`
- View all available Sail commands by running `vendor/bin/sail` without arguments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `vendor/bin/sail artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `vendor/bin/sail artisan list` and check their parameters with `vendor/bin/sail artisan [command] --help`.
- If you're creating a generic PHP class, use `vendor/bin/sail artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `vendor/bin/sail artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `vendor/bin/sail artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `vendor/bin/sail npm run build` or ask the user to run `vendor/bin/sail npm run dev` or `vendor/bin/sail composer run dev`.

=== livewire/core rules ===

# Livewire

- Livewire allow to build dynamic, reactive interfaces in PHP without writing JavaScript.
- You can use Alpine.js for client-side interactions instead of JavaScript frameworks.
- Keep state server-side so the UI reflects it. Validate and authorize in actions as you would in HTTP requests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/sail bin pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/sail bin pint --test --format agent`, simply run `vendor/bin/sail bin pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `vendor/bin/sail artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `vendor/bin/sail artisan make:test --pest SomeFeatureTest` instead of `vendor/bin/sail artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `vendor/bin/sail artisan test --compact` or filter: `vendor/bin/sail artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>
