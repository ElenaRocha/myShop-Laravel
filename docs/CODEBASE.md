# Índice de la Base de Código — MyShop

Este documento proporciona un índice conciso y estructurado de la arquitectura actual del proyecto Laravel. MyShop es una librería online especializada en ficción, no ficción, cómic/manga y literatura juvenil e infantil, con un catálogo persistido en PostgreSQL vía Eloquent.

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
  * **offers** (only: index, show): Mapas de recurso limitado ➔ OfferController
    * offers.index: GET `/offers`
    * offers.show: GET `/offers/{offer}`
  * **brands** (Sin límites): Mapas de CRUD tipo resource ➔ BrandController
    * brands.index: GET `/brands`
    * brands.create: GET `/brands/create`
    * brands.store: POST `/brands`
    * brands.show: GET `/brands/{brand}`
    * brands.edit: GET `/brands/{brand}/edit`
    * brands.update: PUT/PATCH `/brands/{brand}`
    * brands.destroy: DELETE `/brands/{brand}`
  * **suppliers** (Sin límites): Mapas de CRUD tipo resource ➔ SupplierController
    * suppliers.index: GET `/suppliers`
    * suppliers.create: GET `/suppliers/create`
    * suppliers.store: POST `/suppliers`
    * suppliers.show: GET `/suppliers/{supplier}`
    * suppliers.edit: GET `/suppliers/{supplier}/edit`
    * suppliers.update: PUT/PATCH `/suppliers/{supplier}`
    * suppliers.destroy: DELETE `/suppliers/{supplier}`

* **Grupo de rutas con prefijo legal (legal.*)**:
  * legal.privacy: GET `/legal/privacy` ➔ LegalController@privacy
  * legal.terms: GET `/legal/terms` ➔ LegalController@terms
  * legal.cookies: GET `/legal/cookies` ➔ LegalController@cookies

---

## 2. Controladores
Ubicados en el directorio [app/Http/Controllers/](app/Http/Controllers/). La mayoría de los controladores de negocio operan ya con Eloquent sobre PostgreSQL; `BrandController@index/show` y `SupplierController@index/show` también, mientras que sus acciones de escritura (`create`, `store`, `edit`, `update`, `destroy`) siguen simuladas (validan y redirigen, sin persistir) y protegidas con el middleware de token:

* [WelcomeController.php](app/Http/Controllers/WelcomeController.php): Controlador standalone que carga productos con ofertas activas y categorías destacadas para la página de inicio desde la base de datos con Eloquent.
* [ProductController.php](app/Http/Controllers/ProductController.php): Controlador CRUD de recurso completo para el catálogo de libros, persistido en PostgreSQL (`with(['category', 'offer'])`). Incluye el método personalizado `onSale`. Limita las acciones de escritura mediante un token en su middleware.
* [CategoryController.php](app/Http/Controllers/CategoryController.php): Controlador parcial (`index`, `show`) para el listado e inspección de libros filtrados por categoría (Ficción, No ficción, Cómic y manga, Literatura juvenil, Libros infantiles). Usa cargado ansioso (`with(['offer'])`) para mitigar el problema N+1.
* [OfferController.php](app/Http/Controllers/OfferController.php): Controlador de recurso limitado (`index`, `show`) enfocado en mostrar ofertas y los libros correspondientes a cada promoción, directo de base de datos.
* [FavoriteController.php](app/Http/Controllers/FavoriteController.php): Controlador parcial para la lista de favoritos personal de los usuarios (tabla pivote `product_user`). Resuelve los favoritos del primer usuario por defecto de forma optimizada.
* [ContactController.php](app/Http/Controllers/ContactController.php): Controlador simple que resuelve y muestra el formulario estático de contacto.
* [BrandController.php](app/Http/Controllers/BrandController.php): CRUD de recurso completo para las editoriales/marcas. `index` (`Brand::all()`) y `show` usan Eloquent; `create`/`store`/`edit`/`update`/`destroy` validan y redirigen (simulados), protegidos por middleware de token.
* [SupplierController.php](app/Http/Controllers/SupplierController.php): CRUD de recurso completo para los proveedores. `index` y `show` usan Eloquent con `with()`/`load(['address', 'products', 'brands'])`; `create`/`store`/`edit`/`update`/`destroy` siguen simulados (validan campos heredados del mock — `contact_person`, `phone` — que ya no existen en la tabla `suppliers`) y protegidos por middleware de token. Aún importa `LoadsMockData`, sin usarlo tras la migración de `index`/`show` a Eloquent.
* [LegalController.php](app/Http/Controllers/LegalController.php): Controlador de páginas legales estáticas (privacidad, términos, cookies). Carga textos de los diccionarios de traducción.
* [Controller.php](app/Http/Controllers/Controller.php): Controlador base abstracto del framework Laravel.

> **Nota de consistencia**: `resources/views/suppliers/show.blade.php` todavía renderiza `$supplier['contact_person']` y `$supplier['phone']` (campos del mock antiguo) aunque el controlador ya inyecta un modelo `Supplier` de Eloquent sin esas columnas; al implementar `ArrayAccess` sobre atributos inexistentes, la vista no falla pero esos campos se muestran vacíos. `suppliers/index.blade.php` sí está migrada a acceso de objeto (`$supplier->name`, `->address`, `->products->count()`, `->brands`).

---

## 3. Modelos
Ubicados en el directorio [app/Models/](app/Models/):

* [app/Models/User.php](app/Models/User.php):
  * **Tabla asociada**: `users` (por convención de Laravel).
  * **Atributos cargables ($fillable)**: `name`, `email`, `password` (mediante atributo PHP `#[Fillable]`).
  * **Relaciones**: N:M con [Product.php](app/Models/Product.php) a través de `favorites()` (tabla pivote `product_user` con `price_at_add` y timestamps).
  * **Otros**: Usa el trait `HasUuids`.

* [app/Models/Product.php](app/Models/Product.php):
  * **Tabla asociada**: `products`.
  * **Atributos cargables ($fillable)**: `name`, `description`, `price`, `stock`, `is_active`, `category_id`, `offer_id`, `supplier_id` (mediante `#[Fillable]`).
  * **Relaciones**:
    - 1:N inversa con [Category.php](app/Models/Category.php) vía `category()`.
    - 1:N inversa con [Offer.php](app/Models/Offer.php) vía `offer()`.
    - 1:N inversa con [Supplier.php](app/Models/Supplier.php) vía `supplier()` (`supplier_id` nullable; `onDelete('set null')`, el libro se conserva sin proveedor si este se borra).
    - N:M con [User.php](app/Models/User.php) vía `favoritedBy()` (pivote `product_user`, campos `price_at_add` y timestamps).
  * **Otros**: Usa `HasUuids`. Accessor `finalPrice()` que calcula el precio con descuento si hay oferta activa.

* [app/Models/Category.php](app/Models/Category.php):
  * **Tabla asociada**: `categories`.
  * **Atributos cargables**: `name`, `slug`, `description`.
  * **Relaciones**: 1:N con [Product.php](app/Models/Product.php) vía `products()`.
  * **Otros**: `HasUuids`.

* [app/Models/Offer.php](app/Models/Offer.php):
  * **Tabla asociada**: `offers`.
  * **Atributos cargables**: `name`, `slug`, `discount_percentage`, `description`.
  * **Relaciones**: 1:N con [Product.php](app/Models/Product.php) vía `products()`.
  * **Otros**: `HasUuids`.

* [app/Models/Supplier.php](app/Models/Supplier.php):
  * **Tabla asociada**: `suppliers` (`email` único, `softDeletes`).
  * **Atributos cargables**: `name`, `email`.
  * **Relaciones**:
    - 1:1 con [Address.php](app/Models/Address.php) vía `address()` (`addresses.supplier_id` es `unique`).
    - 1:N con [Product.php](app/Models/Product.php) vía `products()`.
    - N:M con [Brand.php](app/Models/Brand.php) vía `brands()` (pivote `brand_supplier`).
  * **Otros**: `HasUuids`, `SoftDeletes`, `HasFactory`.

* [app/Models/Address.php](app/Models/Address.php):
  * **Tabla asociada**: `addresses` (`supplier_id` único + `constrained()->cascadeOnDelete()`: al borrar el proveedor se borra su dirección).
  * **Atributos cargables**: `supplier_id`, `street`, `city`, `postal_code`.
  * **Relaciones**: N:1 (inversa 1:1) con [Supplier.php](app/Models/Supplier.php) vía `supplier()`.
  * **Otros**: `HasUuids`, `HasFactory`. Sin `SoftDeletes`.

* [app/Models/Brand.php](app/Models/Brand.php):
  * **Tabla asociada**: `brands` (`slug` único).
  * **Atributos cargables**: `name`, `slug`, `description` (nullable).
  * **Relaciones**: N:M con [Supplier.php](app/Models/Supplier.php) vía `suppliers()` (pivote `brand_supplier`, con índice único `[brand_id, supplier_id]`).
  * **Otros**: `HasUuids`, `HasFactory`.

---

## 4. Layout, vistas y componentes
El sistema de plantillas Blade se ubica bajo [resources/views/](resources/views/):

* **Layout Base**:
  * [components/layout.blade.php](resources/views/components/layout.blade.php): Layout HTML5 maestro que estructura head, navegación, header, contenido dinámico, footer y scripts.

* **Vistas principales**:
  * [welcome.blade.php](resources/views/welcome.blade.php): Página principal con destacados y categorías.
  * [contact.blade.php](resources/views/contact.blade.php): Formulario simulado de contacto.
  * [legal.blade.php](resources/views/legal.blade.php): Plantilla reutilizada por `LegalController` para los textos legales.

* **Subcarpetas**:
  * **brands**:
    * [brands/index.blade.php](resources/views/brands/index.blade.php): Listado de editoriales/marcas colaboradoras, usando `<x-brand-card>`.
  * **categories**:
    * [categories/index.blade.php](resources/views/categories/index.blade.php): Tarjetas de categorías del catálogo.
    * [categories/show.blade.php](resources/views/categories/show.blade.php): Libros filtrados por categoría seleccionada.
  * **favorites**:
    * [favorites/index.blade.php](resources/views/favorites/index.blade.php): Listado de libros marcados como favoritos.
  * **offers**:
    * [offers/index.blade.php](resources/views/offers/index.blade.php): Galería de ofertas activas.
    * [offers/show.blade.php](resources/views/offers/show.blade.php): Detalle de una promoción y sus libros.
  * **products**:
    * [products/index.blade.php](resources/views/products/index.blade.php): Catálogo general o en oferta.
    * [products/show.blade.php](resources/views/products/show.blade.php): Ficha de un libro (precio, descuento, categoría, oferta).
  * **suppliers**:
    * [suppliers/index.blade.php](resources/views/suppliers/index.blade.php): Listado de proveedores con email, nº de productos (`$supplier->products->count()`), dirección (`$supplier->address`) y marcas asociadas (`$supplier->brands`), todo con acceso a objeto Eloquent.
    * [suppliers/show.blade.php](resources/views/suppliers/show.blade.php): Ficha de un proveedor — **pendiente de migrar**: sigue usando acceso de array a campos del mock antiguo (`contact_person`, `phone`) que no existen en la tabla actual (ver nota en la sección 2).

* **Componentes reutilizables ([components/](resources/views/components/))**:
  * [components/category-card.blade.php](resources/views/components/category-card.blade.php) + [CategoryCard.php](app/View/Components/CategoryCard.php): recibe una instancia de `Category` (tipado estricto) y renderiza su badge.
  * [components/brand-card.blade.php](resources/views/components/brand-card.blade.php) + [BrandCard.php](app/View/Components/BrandCard.php): recibe una instancia de `Brand` (tipado estricto) y renderiza nombre, descripción y enlace a `brands.show`.
  * [components/price-tag.blade.php](resources/views/components/price-tag.blade.php): lógica de precio final de un `Product` (accessor `finalPrice`), precio original y descuento.
  * [components/product-card.blade.php](resources/views/components/product-card.blade.php) + [ProductCard.php](app/View/Components/ProductCard.php): recibe un `Product`, renderiza stock, precio, badges de oferta y botón de favoritos.

* **Partials de maquetación ([partials/](resources/views/partials/))**:
  * [partials/head.blade.php](resources/views/partials/head.blade.php): metadatos, fuentes y assets de Vite.
  * [partials/navigation.blade.php](resources/views/partials/navigation.blade.php): barra de navegación con enlaces a inicio, productos, categorías, ofertas, contacto, **marcas** y **proveedores** (`nav.brands` / `nav.suppliers`).
  * [partials/header.blade.php](resources/views/partials/header.blade.php): cabecera superior.
  * [partials/footer.blade.php](resources/views/partials/footer.blade.php): pie de página, enlaces y secciones legales.
  * [partials/scripts.blade.php](resources/views/partials/scripts.blade.php): dependencias JS vía Vite.

---

## 5. Datos e idiomas
Control de información local no persistente, generación de datos de prueba y diccionarios de internacionalización:

* **Datos de prueba (Mock Data)** en [database/data/](database/data/) — usados por seeders "catálogo curado" vía `LoadsMockData`:
  * [mock-brands.php](database/data/mock-brands.php): 4 editoriales (Editorial Niebla, Lumen de Papel, Tinta de Verano, Pájaro de Luna) con `slug` y `description`.
  * [mock-categories.php](database/data/mock-categories.php): Ficción, No ficción, Cómic y manga, Literatura juvenil, Libros infantiles.
  * [mock-favorites.php](database/data/mock-favorites.php): Relación estática de productos favoritos de un usuario.
  * [mock-offers.php](database/data/mock-offers.php): Promociones con su tasa de descuento.
  * [mock-products.php](database/data/mock-products.php): Catálogo de libros con referencias a marca, categoría y oferta.
  * [mock-suppliers.php](database/data/mock-suppliers.php): 3 proveedores con `name`, `contact_person`, `email`, `phone`. **Nota**: `contact_person` y `phone` no tienen columna en `suppliers` — `SupplierSeeder` los descarta explícitamente (comentados, por si se añaden esas columnas más adelante).

* **Carga de mock data**:
  * [app/Traits/LoadsMockData.php](app/Traits/LoadsMockData.php): expone `getCategories()`, `getOffers()`, `getProducts()`, `getFavorites()`, `getBrands()`, `getSuppliers()`.

* **Factories** en [database/factories/](database/factories/) — usadas por seeders "de volumen":
  * [UserFactory.php](database/factories/UserFactory.php): usuarios con contraseña compartida cacheada y estado `unverified()`.
  * [SupplierFactory.php](database/factories/SupplierFactory.php): `name` (`company()`), `email` único (`companyEmail()`).
  * [AddressFactory.php](database/factories/AddressFactory.php): `street`, `city`, `postal_code`; `supplier_id` vía `Supplier::factory()` (nunca un id inventado).
  * [BrandFactory.php](database/factories/BrandFactory.php): `name` (`company()`), `slug` único, `description`.

* **Seeders** en [database/seeders/](database/seeders/), orquestados por [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php) en este orden: `UserSeeder` → `CategorySeeder` → `OfferSeeder` → `ProductSeeder` → `ProductUserSeeder` → `BrandSeeder` → `SupplierSeeder`. `BrandSeeder` y `SupplierSeeder` cargan su catálogo curado desde el mock (vía `LoadsMockData`), descartando el `id` numérico (lo genera `HasUuids`).

* **Migraciones relevantes** en [database/migrations/](database/migrations/) (además de las tablas base `users`/`categories`/`offers`/`products`/`product_user`):
  * `create_suppliers_table`: `id` uuid, `name`, `email` único, `softDeletes()`, timestamps.
  * `create_addresses_table`: `id` uuid, `supplier_id` (FK único → 1:1, `cascadeOnDelete()`), `street`, `city`, `postal_code`.
  * `add_supplier_id_to_products_table`: `supplier_id` nullable en `products` (`onDelete('set null')`).
  * `create_brands_table`: `id` uuid, `name`, `slug` único, `description` nullable.
  * `create_brand_supplier_table`: pivote `brand_id` + `supplier_id` (ambos `cascadeOnDelete()`), único por par.

* **Diccionarios de idiomas**:
  * [lang/es/messages.php](lang/es/messages.php) / [lang/en/messages.php](lang/en/messages.php): incluyen `nav.*` (home, products, categories, offers, contact, favorites, **brands**, **suppliers**), `suppliers.*` (title, subtitle, **email**, **products**, **address**, **brands**, **empty**), `empty.*`, `buttons.*`, `brands.title`, textos de producto/oferta y legales.
