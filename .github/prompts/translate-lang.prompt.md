---
agent: 'agent'
description: 'Traduce un archivo de idioma de Laravel a otro idioma'
---

Traduce el archivo `lang/es/messages.php` al idioma ${input:código destino (ej. en)}.
Reglas:
- Mantén EXACTAMENTE las mismas claves; traduce solo los valores.
- No toques los marcadores de variables (`:attribute`, `{name}`, `:count`).
- Respeta los términos propios de mi dominio (nombres de productos y categorías).
- Devuelve un archivo PHP válido: empieza por `<?php` y `return [`, ciérralo con `];`, y conserva la sintaxis `'clave' => 'valor',` en cada línea, con comillas en clave y valor.
- Si un valor lleva un apóstrofo (p. ej. francés `l'article`, italiano `un'offerta`), escápalo (`l\'article`) o usa comillas dobles, para no romper la cadena PHP.
Escribe el resultado en `lang/${input:código}/messages.php`. Solo código PHP, sin explicaciones.