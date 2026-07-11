---
agent: 'agent'
description: 'Genera un controller resource Laravel 13 con PHP Attributes'
---

Lee el archivo `app/Http/Controllers/ProductController.php` como referencia de estilo y patrón.

Genera un nuevo controller para el modelo `${input:Nombre del modelo (PascalCase)}` que:
1. Siga exactamente la misma estructura que ProductController
2. Use el atributo `#[Middleware('token:secret123', only: [...])]` (namespace
   `Illuminate\Routing\Attributes\Controllers\Middleware`) sobre los métodos de escritura
3. Incluya los 7 métodos resource (index, create, store, show, edit, update, destroy)
4. Tenga validación básica con `$request->validate([...])` en store y update
5. Use type hints completos en todos los parámetros
6. Indique la línea `Route::resource(...)` a añadir en routes/web.php
7. Lea sus datos con el trait `App\Traits\LoadsMockData` (no hay base de datos: **no uses Eloquent**). Crea también el mock `database/data/mock-{modelos}.php` y su getter `get{Modelo}s()` en el trait, siguiendo `mock-products.php` / `getProducts()`. El getter vive **solo en el trait**: no lo redefinas dentro del controller. `index()` lo llama con `$this->get{Modelo}s()`.

Escribe el archivo en `app/Http/Controllers/{Modelo}Controller.php`.