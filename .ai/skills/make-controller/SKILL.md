---
description: 'Genera un controller resource Laravel 13 (Eloquent) leyendo ProductController como referencia; protección por grupo de rutas y validación con FormRequests.'
---

# Skill: make-controller

Genera el controller resource de un modelo Laravel 13 (p. ej. `Product`), tomando
`app/Http/Controllers/ProductController.php` como referencia de estilo y estructura:

1. Nómbralo `{Modelo}Controller` en `app/Http/Controllers/`.
2. Implementa los 7 métodos resource (index, create, store, show, edit, update,
   destroy) con type hints completos y tipos de retorno (`View` / `RedirectResponse`).
3. Accede a los datos con **Eloquent**: `findOrFail($id)` para localizar un registro
   por su id y `with()` para cargar las relaciones que la vista necesite (evita N+1).
4. Valida `store()` y `update()` con Form Requests dedicados (`Store{Modelo}Request`
   y `Update{Modelo}Request`) y usa `$request->validated()` para crear o actualizar.
   Si esos Form Requests no existen, indícalo para generarlos con la skill **make-request**.
5. Deja el control de acceso (autenticación, rol de administrador) al grupo de rutas
   de `routes/web.php`; el controlador no define middleware.
6. Indica la línea `Route::resource(...)` que añadir en `routes/web.php` y en qué grupo
   de middleware va.

Escribe el archivo en `app/Http/Controllers/{Modelo}Controller.php`.