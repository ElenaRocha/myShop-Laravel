---
description: 'Genera el seeder de un modelo (factory o mock) y lo registra en DatabaseSeeder respetando el orden de las claves foráneas.'
---

# Skill: make-seeder

Dado el nombre de un modelo, genera `database/seeders/{Modelo}Seeder.php` y regístralo en `DatabaseSeeder`:

1. **Elige la fuente de datos**:
   - **Catálogo curado** (debe aparecer tal cual en la interfaz): carga el mock con `getX()` del trait `App\Traits\LoadsMockData` y `unset($item['id'])` antes de `Model::create()`. NUNCA regeneres ni sobrescribas los archivos `database/data/mock-*.php`.
   - **Volumen** (registros realistas en cantidad): usa la factory. Encadena las relaciones dependientes con `->has(Related::factory(), 'relacion')` para no crear registros huérfanos ni duplicados.

2. **Respeta las claves foráneas**: siembra un modelo DESPUÉS de aquellos a los que referencia.

3. **Regístralo en `database/seeders/DatabaseSeeder.php`**:
   - LEE el array `$this->call([...])` actual y AÑADE el seeder nuevo al final; nunca reemplaces ni reordenes los existentes.
   - El catálogo (del que otros dependen) va antes del que lo referencia.

Muestra los archivos generados para que los revises antes de guardarlos.