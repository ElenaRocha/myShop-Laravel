# Índice de la Base de Código — MyShop

Este documento proporciona un índice conciso y estructurado de la arquitectura actual del proyecto Laravel.

## 1. Rutas
Las rutas de la aplicación están definidas en [routes/web.php](routes/web.php) y se mapean de la siguiente manera:

* **Páginas Generales**:
  * welcome: GET `/` ➔ WelcomeController@index
  * contact: GET `/contact` ➔ Closure ➔ vista contact

* **Categorías**:
  * categories.index: GET `/categories` ➔ CategoryController@index
  * categories.show: GET `/categories/{category}` ➔ CategoryController@show

* **Favoritos**:
  * favorites.index: GET `/favorites` ➔ FavoriteController@index
  * favorites.store: POST `/favorites/{id}` ➔ FavoriteController@store
  * favorites.destroy: DELETE `/favorites/{id}` ➔ FavoriteController@destroy

* **Productos en Oferta**:
  * products.on-sale: GET `/products/on-sale` ➔ ProductController@onSale

* **Recursos (Route::resource)**:
  * **products** (Sin límites): Mapas de CRUD tipo resource ➔ ProductController
    * products.index: GET `/products`
    * products.create: GET `/products/create`
    * products.store: POST `/products`
    * products.show: GET `/products/{product}`
    * products.edit: GET `/products/{product}/edit`
    * products.update: PUT/PATCH `/products/{product}`
    * products.destroy: DELETE `/products/{product}`
  * **brands** (Sin límites): Mapas de CRUD tipo resource ➔ BrandController
    * brands.index: GET `/brands`
    * brands.create: GET `/brands/create`
    * brands.store: POST `/brands`
    * brands.show: GET `/brands/{brand}`
    * brands.edit: GET `/brands/{brand}/edit`
    * brands.update: PUT/PATCH `/brands/{brand}`
    * brands.destroy: DELETE `/brands/{brand}`
  * **offers** (only: index, show): Mapas de recurso limitado ➔ OfferController
    * offers.index: GET `/offers`
    * offers.show: GET `/offers/{offer}`
  * **suppliers** (only: index): Mapa de recurso limitado ➔ SupplierController
    * suppliers.index: GET `/suppliers`

* **Grupo de rutas con prefijo legal (legal.*)**:
  * legal.privacy: GET `/legal/privacy` ➔ LegalController@privacy
  * legal.terms: GET `/legal/terms` ➔ LegalController@terms
  * legal.cookies: GET `/legal/cookies` ➔ LegalController@cookies

---

## 2. Controladores
Ubicados en el directorio [app/Http/Controllers/](app/Http/Controllers/). Todos los controladores de negocio interactúan principalmente con datos simulados (mock data):

* [WelcomeController.php](app/Http/Controllers/WelcomeController.php): Controlador standalone que gestiona la carga de productos y categorías destacadas de la página de inicio. Usa el trait LoadsMockData.
* [ProductController.php](app/Http/Controllers/ProductController.php): Controlador CRUD de recurso completo. Incluye el método personalizado onSale. Usa el trait LoadsMockData y limita las acciones de modificación mediante un token en su middleware (create, store, edit, update, destroy).
* [CategoryController.php](app/Http/Controllers/CategoryController.php): Controlador parcial para el listado e inspección de productos filtrados por categoría. Usa el trait LoadsMockData.
* [OfferController.php](app/Http/Controllers/OfferController.php): Controlador de recurso enfocado en mostrar ofertas y los videojuegos correspondientes a cada oferta. Usa el trait LoadsMockData.
* [FavoriteController.php](app/Http/Controllers/FavoriteController.php): Controlador parcial para la lista de favoritos personal de los usuarios. Usa el trait LoadsMockData y restringe la edición de favoritos (store, destroy) por medio de su middleware.
* [BrandController.php](app/Http/Controllers/BrandController.php): Controlador CRUD de recurso completo para marcas de hardware y editores de software. Usa el trait LoadsMockData y restringe la edición mediante middleware.
* [SupplierController.php](app/Http/Controllers/SupplierController.php): Controlador limitado a la vista de índice de distribuidores mayoristas de la tienda. Usa el trait LoadsMockData.
* [LegalController.php](app/Http/Controllers/LegalController.php): Controlador de páginas legales estáticas (políticas de privacidad, términos de servicio y políticas de cookies). Carga textos de los diccionarios de traducción.
* [Controller.php](app/Http/Controllers/Controller.php): Controlador base abstracto del framework Laravel.

---

## 3. Modelos
Ubicados en el directorio [app/Models/](app/Models/). Actualmente solo existe un modelo persistente debido al uso de mock data:

* [User.php](app/Models/User.php):
  * **Tabla asociada**: users (por convención de Laravel).
  * **Atributos cargables ($fillable)**: name, email, password (definido mediante atributo PHP #[Fillable]).
  * **Relaciones**: Ninguna configurada de momento en la capa de datos.

---

## 4. Layout, vistas y componentes
El sistema de plantillas Blade se ubica bajo el directorio [resources/views/](resources/views/):

* **Layout Base**:
  * [components/layout.blade.php](resources/views/components/layout.blade.php): Layout HTML5 maestro de la aplicación Universo Gamer que estructura las secciones comunes (head, navegación, header, contenido dinámico, footer y scripts).

* **Vistas principales**:
  * [welcome.blade.php](resources/views/welcome.blade.php): Página principal del e-commerce que muestra sliders de consolas/juegos y secciones destacadas.
  * [contact.blade.php](resources/views/contact.blade.php): Formulario simulado de contacto y soporte técnico para el usuario.
  * [legal.blade.php](resources/views/legal.blade.php): Plantilla reutilizada por el LegalController para presentar los textos legales en el idioma correspondiente.

* **Subcarpetas**:
  * **brands**:
    * [brands/index.blade.php](resources/views/brands/index.blade.php): Listado total de marcas colaboradoras.
  * **categories**:
    * [categories/index.blade.php](resources/views/categories/index.blade.php): Tarjetas de categorías del Universo Gamer.
    * [categories/show.blade.php](resources/views/categories/show.blade.php): Vista filtrada que enseña productos en base a la categoría seleccionada.
  * **favorites**:
    * [favorites/index.blade.php](resources/views/favorites/index.blade.php): Listado de productos marcados como favoritos por el cliente.
  * **offers**:
    * [offers/index.blade.php](resources/views/offers/index.blade.php): Galería de ofertas activas en la tienda.
    * [offers/show.blade.php](resources/views/offers/show.blade.php): Detalle de una promoción y juegos incluidos en ella.
  * **products**:
    * [products/index.blade.php](resources/views/products/index.blade.php): Catálogo general o en oferta de videojuegos y consolas.
    * [products/show.blade.php](resources/views/products/show.blade.php): Ficha técnica, precio sugerido, descuento aplicado y descripción detallada del artículo.
  * **suppliers**:
    * [suppliers/index.blade.php](resources/views/suppliers/index.blade.php): Presentación corporativa de los distribuidores de MyShop.

* **Componentes reutilizables ([components/](resources/views/components/))**:
  * [components/category-card.blade.php](resources/views/components/category-card.blade.php): Componente visual para mostrar una categoría con su respectivo badge informativo.
  * [components/price-tag.blade.php](resources/views/components/price-tag.blade.php): Componente encargado de calcular y visualizar el precio original, el precio de oferta y el porcentaje de descuento si corresponde.
  * [components/product-card.blade.php](resources/views/components/product-card.blade.php): Tarjeta de producto estándar con detalles de disponibilidad, imagen, precio y botón de agregar a favoritos.

* **Partials de maquetación ([partials/](resources/views/partials/))**:
  * [partials/head.blade.php](resources/views/partials/head.blade.php): Metadatos, importación de fuentes de Google Fonts y recursos de hoja de estilos compilados por Vite.
  * [partials/navigation.blade.php](resources/views/partials/navigation.blade.php): Barra de navegación adaptable (responsive) con enlaces a inicio, productos, categorías, ofertas y contacto.
  * [partials/header.blade.php](resources/views/partials/header.blade.php): Cabecera superior con la temática gamer de la tienda.
  * [partials/footer.blade.php](resources/views/partials/footer.blade.php): Pie de página con copyright, enlaces rápidos de redes sociales y secciones de información legal.
  * [partials/scripts.blade.php](resources/views/partials/scripts.blade.php): Carga de dependencias JavaScript a través de Vite.

---

## 5. Datos e idiomas
Control de información local no persistente y diccionarios de internacionalización:

* **Datos de prueba (Mock Data)** en [database/data/](database/data/):
  * [mock-brands.php](database/data/mock-brands.php): Configura marcas líderes en el nicho del desarrollo de videojuegos o hardware (Sony, Nintendo, Microsoft, Valve, etc.).
  * [mock-categories.php](database/data/mock-categories.php): Clasificadores como Consolas, Periféricos, Videojuegos y Merchandising con sus respectivos slugs e íconos.
  * [mock-favorites.php](database/data/mock-favorites.php): Relación estática de productos agregados a los favoritos de un usuario.
  * [mock-offers.php](database/data/mock-offers.php): Estructura promociones especiales actuales (como Black Friday, Rebajas de Verano) cargando tasas específicas de descuento.
  * [mock-products.php](database/data/mock-products.php): Catálogo de hardware, mandos gamer y videojuegos con referencias a su respectiva marca, categoría y oferta.
  * [mock-suppliers.php](database/data/mock-suppliers.php): Datos de contacto de los principales proveedores locales de la tienda.

* **Carga de datos**:
  * [app/Traits/LoadsMockData.php](app/Traits/LoadsMockData.php): Trait que inyecta en los controladores la lógica de lectura rápida desde los ficheros PHP de la carpeta de datos de prueba, además de integrar la función de enriquecimiento para calcular el descuento sobre los productos mediante arrays mapeados.

* **Diccionarios de idiomas**:
  * [lang/es/messages.php](lang/es/messages.php): Archivo asociativo PHP para traducciones y etiquetas principales en español (Universo Gamer, ofertas de temporada, textos de privacidad, etc.).
  * [lang/en/messages.php](lang/en/messages.php): Duplicado del diccionario del idioma para presentar la plataforma MyShop en inglés.