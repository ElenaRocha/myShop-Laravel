---
agent: 'agent'
description: 'Genera un modelo Eloquent leyendo su migración: $fillable, traits, casts y relaciones inferidas de las claves foráneas'
---

Dado el nombre de un modelo, genera `app/Models/{Modelo}.php` leyendo su migración (y las de los modelos relacionados) en `database/migrations/`:

1. **Comprobación previa**: si `app/Models/{Modelo}.php` ya existe, muéstralo y pregunta antes de sobrescribir (puede tener accessors, scopes o lógica añadida a mano que no debe perderse).

2. **Deduce la configuración del modelo**:
   - `$fillable`: las columnas asignables (ni `id`, ni timestamps, ni `deleted_at`). Decláralas con el atributo `#[Fillable([...])]` de `Illuminate\Database\Eloquent\Attributes\Fillable` (impórtalo); no declares además la propiedad `$fillable`.
     - *Nota (Laravel 13):* si combinas `#[Fillable]` con un trait cuyo `initialize<Trait>()` llama a `mergeFillable()`, el atributo puede perderse y saltar `MassAssignmentException` (issue `laravel/framework#59270`). Si te ocurre, cae a `protected $fillable = [...]` como propiedad y avísalo en el resumen.
   - Traits: `HasUuids` si la PK es `uuid('id')`; `SoftDeletes` si hay `softDeletes()`/`deleted_at`; `HasFactory` siempre.
   - `casts()` para `decimal`, `boolean` o fechas. No castees las columnas UUID (PK/FK) si la BD ya las devuelve como string.

3. **Infiere las relaciones desde las claves foráneas** (lee también la migración del otro extremo para el lado inverso):
   - `foreignUuid('x_id')` sin `unique` → `belongsTo(X::class)` aquí; `hasMany` en `X`.
   - `foreignUuid('x_id')->unique()` → `belongsTo(X::class)` aquí; `hasOne` en `X` (1:1).
   - Tabla pivote `a_b` (dos FKs, sin PK propia) → `belongsToMany` en ambos modelos.
   - FK que apunta a la propia tabla (p. ej. `parent_id`) → relación auto-referenciada (`belongsTo(self::class, 'parent_id')` y `hasMany(self::class, 'parent_id')`).
   - Columnas `{x}able_id` + `{x}able_type` → relación polimórfica (`morphTo()` aquí; `morphMany`/`morphOne` en el otro extremo).
   - Importa los tipos de relación que uses (`BelongsTo`, `HasMany`, `HasOne`, `BelongsToMany`, `MorphTo`…).

4. Sigue las convenciones del proyecto (PHPDoc de retorno, orden de imports): revisa un modelo existente como referencia.

Muestra el archivo generado para que lo revises antes de guardarlo.