---
agent: 'agent'
description: 'Sincroniza docs/CODEBASE.md analizando de forma inteligente los cambios del repositorio'
---

Sincroniza y actualiza la memoria técnica en `docs/CODEBASE.md` con el estado actual del proyecto Laravel analizando solo los archivos que han cambiado:

1. **Detección rápida de cambios (Git)**:
   - Comprueba mediante las herramientas de Git si existen diferencias activas, archivos modificados recientemente en la rama actual o adiciones en relación con los últimos commits.
   - Si identificas cambios en controladores, modelos, rutas o componentes visuales, lee el contenido de esos archivos específicos para extraer las firmas actualizadas de métodos, atributos o relaciones.

2. **Inspección de estructura fija (Fallback)**:
   - Si no detectas diferencias recientes en el repositorio (el diff está vacío), realiza una exploración rápida de las carpetas clave para asegurarte de que todo está completo sin necesidad de leer todos los archivos en profundidad:
     - **Rutas** (`routes/web.php`): una línea por ruta con nombre, método HTTP, URI y destino (`Controlador@método` o "Closure -> vista"). Agrupa por prefijo común e indica límites de recursos.
     - **Controladores** (`app/Http/Controllers/`): comprueba qué controladores y métodos nuevos existen.
     - **Modelos** (`app/Models/`): tabla, `$fillable` y relaciones de cada uno.
     - **Layout, vistas y componentes** (`resources/views/`): layout, subcarpetas, componentes de `components/` y partials.
     - **Datos e idiomas**: archivos de `database/data/` (y el trait `App\Traits\LoadsMockData`) y diccionarios `lang/{locale}/messages.php`.

3. **Mantenimiento del documento**:
   - Si `docs/CODEBASE.md` ya existe, actualiza solo lo que haya cambiado y conserva el resto estructurado, conciso e idealmente en una página.
   - Si no existe, créalo desde cero en base a las mismas secciones clave.