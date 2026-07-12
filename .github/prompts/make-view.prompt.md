---
agent: 'agent'
description: 'Genera una vista Blade de Laravel componiendo <x-layout> y los componentes existentes'
---

Lee `resources/views/products/index.blade.php` como referencia de estilo.

Genera la vista `${input:Ruta de la vista (ej: brands/index)}` que:
1. Componga `<x-layout>` (no escribas <html> ni <head>)
2. Reutilice los componentes existentes (`<x-product-card>`…) en vez de duplicar HTML
3. Recorra los datos con @foreach; cero lógica de negocio en la vista
4. Use la misma **estructura y estilo** que `products/index.blade.php`, pero con los **textos propios del recurso** (p. ej. el título «Marcas»); no copies sus textos literalmente. En texto fijo por ahora
5. Respete una accesibilidad mínima: `alt` en imágenes, jerarquía de encabezados, `label`/`for` en formularios

Escribe solo el archivo Blade.