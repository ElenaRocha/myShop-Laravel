# MyShop 2026 — repositorio de entregas

Este es **tu** repositorio para todo el curso *Introducción a Laravel & IA 101*. Aquí entregas las prácticas de las cinco sesiones; **no se crea un repositorio nuevo por práctica**.

> Este archivo se llama `INSTRUCCIONES.md` a propósito (y no `README.md`) para que, al enlazar tu proyecto Laravel en la **Sesión 1**, el `git pull` se mezcle sin conflictos con el `README.md` que genera Laravel.

## Cómo se entrega

1. Trabajas en tu proyecto Laravel local (lo creas en la práctica de la Sesión 1) y lo conectas a este repositorio.
2. Cada entrega es un **tag** sobre tu commit:
   - `sN-1` → **práctica guiada** de la sesión *N* (solo da el visto bueno ✅/❌, no genera clave).
   - `sN-2` → **ampliación** de la sesión *N* (la entrega **evaluable**: al pasar los tests, el sistema publica tu **clave de validación**).
3. Al empujar el tag, unos minutos después aparece **en el commit etiquetado**: un **check ✅/❌** y un **comentario** del sistema con el detalle (y, en las ampliaciones, la clave).

```bash
git add .
git commit -m "S1: práctica guiada"
git tag s1-1
git push origin s1-1
```

Si una entrega falla y corriges el código, mueve el tag:

```bash
git tag -f s1-1 && git push origin s1-1 --force
```

## Importante

- La corrección es **centralizada**: la hace el profesorado en su propio entorno. Este repositorio **no** ejecuta tests ni contiene secretos.
- Los pasos detallados de cada entrega están en el material del curso, en la guía de entregas de cada sesión.
