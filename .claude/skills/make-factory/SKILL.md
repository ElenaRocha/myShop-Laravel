---
description: 'Genera la factory de un modelo Eloquent a partir de su migración y su $fillable.'
---

# Skill: make-factory

Dado el nombre de un modelo Eloquent, genera su factory:

1. **Lee el modelo y su migración**:
   - Abre `app/Models/{Modelo}.php` para conocer su `$fillable`, sus `casts()` y sus relaciones.
   - Localiza su migración en `database/migrations/` para saber el tipo de cada columna (string, decimal, boolean, `foreignUuid`, `nullable`, índices `unique`...).

2. **Escribe `database/factories/{Modelo}Factory.php`**:
   - Un valor Faker coherente con el tipo de cada columna del `$fillable`.
   - Para las claves foráneas, usa la factory del modelo relacionado (`OtroModelo::factory()`), nunca un id inventado.
   - No fijes la clave primaria (la genera `HasUuids`) ni las columnas de borrado lógico (`deleted_at`).
   - Usa `fake()->unique()` en las columnas con índice `unique` (por ejemplo `email` o `slug`).

Muestra el archivo generado para que lo revises antes de guardarlo.