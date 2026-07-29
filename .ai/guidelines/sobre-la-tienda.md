# MyShop

Convenciones y contexto del proyecto para el asistente de IA.

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
Estos ficheros son recetas/checklist para usar cuando se pida una tarea equivalente:
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
