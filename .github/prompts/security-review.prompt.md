---
agent: 'agent'
description: Audita la seguridad de un controlador, FormRequest o vista Blade de Laravel y devuelve un informe ✅/⚠️/❌.
---

Revisa el archivo indicado y comprueba:
- Autorización: ¿el método exige usuario autenticado? ¿hay riesgo de IDOR (tocar datos de otro usuario)?
- Datos: ¿los IDs se validan con findOrFail? ¿la escritura usa el usuario autenticado, no User::first()?
- Restos: ¿queda algún candado de prueba (el token de la práctica anterior) sin sustituir por auth?
Informe: ✅ correcto · ⚠️ mejorable (con sugerencia) · ❌ crítico (con el fix).