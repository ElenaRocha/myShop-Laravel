---
description: 'Genera los Form Requests (Store/Update) de un recurso leyendo su migración; marca los huecos de negocio.'
---

# Skill: make-request

Dado el nombre de un recurso (p. ej. `Product`), genera
`app/Http/Requests/Store{Recurso}Request.php` y `Update{Recurso}Request.php`
leyendo su migración en `database/migrations/`:

1. **Reglas mecánicas desde la migración** (una por columna asignable; ni id ni timestamps):
   - Tipo → `string` / `integer` / `numeric` / `boolean` / `date`.
   - `nullable()` → `nullable`.
   - No nullable y **sin default** → `required`.
   - No nullable pero **con `default(...)`** → la BD ya cubre el valor: NO lo marques
     `required` por sistema. Que sea `required`, se omita o vaya `sometimes` depende de
     si el formulario pide ese campo en esa acción → déjalo como `// TODO negocio`.
   - `foreignUuid('x_id')` → `exists:{tabla},id`.
   - columna `unique()` → `unique:{tabla},{col}`; en el Update,
     `Rule::unique('{tabla}','{col}')->ignore($this->route('{param}')->id)`
     (importa `Illuminate\Validation\Rule`).
   - columnas **identificativas** (`name`, `slug`, `email`, `sku`…) SIN índice `unique`
     en la migración → sugiere `unique` como `// TODO negocio`: suele ser una regla de
     negocio aunque la BD no la imponga.
   - columna `image` nullable → `nullable|image|mimes:jpeg,png,jpg,webp|max:2048`.
2. **authorize()**: por defecto `return auth()->check();` (usuario autenticado).
3. **Sin `messages()`**: los mensajes van en `lang/es/validation.php` (`custom` + `attributes`).
4. **Huecos de NEGOCIO (no están en la migración): márcalos con `// TODO negocio: …`**
   — longitudes máximas (`max:N`), campos solo-creación o solo-edición, límites
   numéricos y reglas condicionales. Tú decides, no la migración.

Muestra los dos archivos para que los revises antes de guardarlos.