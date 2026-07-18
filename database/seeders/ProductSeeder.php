<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cargamos los productos del mock a crear
        $products = $this->getProducts();

        // 2. Cargamos todos los registros de la base de datos de categorías y ofertas.
        $categoriesDb = Category::all();
        $offersDb = Offer::all();

        // 3. Asociamos el ID numérico del mock de categorias con el UUID real
        $categoriaMap = [];
        foreach ($this->getCategories() as $cat) {
            $categoriaReal = $categoriesDb->where('slug', $cat['slug'])->first();
            $categoriaMap[$cat['id']] = $categoriaReal ? $categoriaReal->id : null;
        }

        // 4. Asociamos el ID numérico del mock de ofertas con el UUID real
        $ofertaMap = [];
        foreach ($this->getOffers() as $off) {
            $ofertaReal = $offersDb->where('slug', $off['slug'])->first();
            $ofertaMap[$off['id']] = $ofertaReal ? $ofertaReal->id : null;
        }

        // 5. Insertamos los productos traduciendo las claves foráneas del mock a los UUID reales de la BD
        foreach ($products as $product) {
            // Traduce los id numéricos del mock a los UUID reales de la BD.
            $product['category_id'] = $categoriaMap[$product['category_id']];
            $product['offer_id'] = $product['offer_id'] !== null
                ? ($ofertaMap[$product['offer_id']])
                : null;

            unset($product['id']);
            Product::create($product);
        }
    }
}