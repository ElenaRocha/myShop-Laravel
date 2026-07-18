# Índice de la Base de Código — MyShop

Este documento proporciona un índice conciso y estructurado de la arquitectura actual del proyecto Laravel.

## 1. Rutas
Las rutas de la aplicación están definidas en [routes/web.php](routes/web.php) y se mapean de la siguiente manera:

* **Páginas Generales**:
  * welcome: GET `/` ➔ WelcomeController@index
  * contact: GET `/contact` ➔ ContactController@index

* **Categorías**:
  * categories.index: GET `/categories` ➔ CategoryController@index
  * categories.show: GET `/categories/{category}` ➔ CategoryController@show

* **Favoritos** (el listado es de solo lectura `store`/`destroy`):
  * favorites.index: GET `/favorites` ➔ FavoriteController@index
  * favorites.store: POST `/favorites/{id}` ➔ FavoriteController@store *(stub)*
  * favorites.destroy: DELETE `/favorites/{id}` ➔ FavoriteController@destroy *(stub)*

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
Ubicados en el directorio [app/Http/Controllers/](app/Http/Controllers/). Con la introducción de modelos persistentes basados en Eloquent, se ha migrado la mayoría de los controladores de negocio para que dejen de usar datos simulados (mock data) en memoria y operen directamente con la base de datos PostgreSQL:

* [WelcomeController.php](app/Http/Controllers/WelcomeController.php): Controlador standalone que gestiona la carga de productos con ofertas activas y categorías destacadas de la página de inicio desde la base de datos con Eloquent.
* [ProductController.php](app/Http/Controllers/ProductController.php): Controlador CRUD de recurso completo para videojuegos y consolas persistidos en PostgreSQL. Incluye el método personalizado `onSale`. Limita las acciones de modificación mediante un token en su middleware (`create`, `store`, `edit`, `update`, `destroy`).
* [CategoryController.php](app/Http/Controllers/CategoryController.php): Controlador parcial para el listado e inspección de productos filtrados por categoría. Resuelve las consultas a base de datos usando cargado ansioso (`with(['offer'])`) para mitigar el problema N+1.
* [OfferController.php](app/Http/Controllers/OfferController.php): Controlador de recurso enfocado en mostrar ofertas y los videojuegos correspondientes a cada código de promoción directo de base de datos.
* [FavoriteController.php](app/Http/Controllers/FavoriteController.php): Controlador parcial para la lista de favoritos personal de los usuarios vinculados en PostgreSQL. Resuelve productos favoritos del primer usuario por defecto junto con la información pivote de forma optimizada.
* [ContactController.php](app/Http/Controllers/ContactController.php): Controlador simple encargado de resolver y mostrar el formulario estático de contacto del e-commerce.
* [BrandController.php](app/Http/Controllers/BrandController.php): Controlador CRUD de recurso completo para marcas de hardware y editores de software. Usa el trait `LoadsMockData` y restringe la edición mediante middleware.
* [SupplierController.php](app/Http/Controllers/SupplierController.php): Controlador limitado a la vista de índice de distribuidores mayoristas de la tienda. Usa el trait `LoadsMockData`.
* [LegalController.php](app/Http/Controllers/LegalController.php): Controlador de páginas legales estáticas (políticas de privacidad, términos de servicio y políticas de cookies). Carga textos de los diccionarios de traducción.
* [Controller.php](app/Http/Controllers/Controller.php): Controlador base abstracto del framework Laravel.

---

## 3. Modelos
Ubicados en el directorio [app/Models/](app/Models/). Actualmente se han definido los modelos persistentes para estructurar el backend persistente de la tienda:

* [app/Models/User.php](app/Models/User.php):
  * **Tabla asociada**: `users` (por convención de Laravel).
  * **Atributos cargables ($fillable)**: `name`, `email`, `password` (definido mediante atributo PHP `#[Fillable]`).
  * **Relaciones**: Relación N:M con [app/Models/Product.php](app/Models/Product.php) a través de la relación `favorites()` (tabla pivote `product_user` con pivote `price_at_add` y marcas de tiempo).
  * **Otros**: Usa el trait `HasUuids` para identificar de forma segura los registros.

* [app/Models/Product.php](app/Models/Product.php):
  * **Tabla asociada**: `products` (por convención de Laravel).
  * **Atributos cargables ($fillable)**: `name`, `description`, `price`, `stock`, `is_active`, `category_id`, `offer_id` (mediante atributo PHP `#[Fillable]`).
  * **Relaciones**:
    - Relación 1:N inversa con [app/Models/Category.php](app/Models/Category.php) a través de `category()`.
    - Relación 1:N inversa con [app/Models/Offer.php](app/Models/Offer.php) a través de `offer()`.
    - Relación N:M con [app/Models/User.php](app/Models/User.php) a través de `favoritedBy()` (tabla pivote `product_user` con los campos `price_at_add` y marcas de tiempo).
  * **Otros**: Usa el trait `HasUuids`. Define un accessor `finalPrice()` que calcula dinámicamente el precio final con descuento si el producto tiene una oferta activa, simplificando la lógica de las plantillas.

* [app/Models/Category.php](app/Models/Category.php):
  * **Tabla asociada**: `categories` (por convención de Laravel).
  * **Atributos cargables ($fillable)**: `name`, `slug`, `description` (mediante atributo PHP `#[Fillable]`).
  * **Relaciones**: Relación 1:N con [app/Models/Product.php](app/Models/Product.php) a través de `products()`.
  * **Otros**: Usa el trait `HasUuids`.

* [app/Models/Offer.php](app/Models/Offer.php):
  * **Tabla asociada**: `offers` (por convención de Laravel).
  * **Atributos cargables ($fillable)**: `name`, `slug`, `discount_percentage`, `description` (mediante atributo PHP `#[Fillable]`).
  * **Relaciones**: Relación 1:N con [app/Models/Product.php](app/Models/Product.php) a través de `products()`.
  * **Otros**: Usa el trait `HasUuids`.

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
  * [components/category-card.blade.php](resources/views/components/category-card.blade.php): Componente visual respaldado por la clase `CategoryCard.php` que recibe una instancia del modelo `Category` para procesar y renderizar su respectivo badge temático.
  * [components/price-tag.blade.php](resources/views/components/price-tag.blade.php): Componente encargado de procesar la lógica de negocio del precio de venta final de un `Product`, visualizando su coste original, precio con oferta (calculado mediante el accessor `finalPrice`) y el porcentaje de descuento si corresponde.
  * [components/product-card.blade.php](resources/views/components/product-card.blade.php): Tarjeta respaldada por la clase `ProductCard.php` que recibe una instancia del modelo `Product`, renderizando sus atributos de stock, imagen, precio con descuento, badges promocionales y el botón de agregar a favoritos.

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
  * [app/Traits/LoadsMockData.php](app/Traits/LoadsMockData.php): Trait que carga los arrays de mock en los seeders para obtener el conjunto de datos a precargar.

* **Diccionarios de idiomas**:
  * [lang/es/messages.php](lang/es/messages.php): Archivo asociativo PHP para traducciones y etiquetas principales en español (Universo Gamer, ofertas de temporada, textos de privacidad, etc.).
  * [lang/en/messages.php](lang/en/messages.php): Duplicado del diccionario del idioma para presentar la plataforma MyShop en inglés.