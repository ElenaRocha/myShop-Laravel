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
        $products = $this->getProducts();

        $categoriesDb = Category::all();
        $offersDb = Offer::all();

        $categoriaMap = [];
        foreach ($this->getCategories() as $cat) {
            $categoriaReal = $categoriesDb->where('slug', $cat['slug'])->first();
            $categoriaMap[$cat['id']] = $categoriaReal ? $categoriaReal->id : null;
        }

        $ofertaMap = [];
        foreach ($this->getOffers() as $off) {
            $ofertaReal = $offersDb->where('slug', $off['slug'])->first();
            $ofertaMap[$off['id']] = $ofertaReal ? $ofertaReal->id : null;
        }

        foreach ($products as $product) {
            $product['category_id'] = $categoriaMap[$product['category_id']];
            $product['offer_id'] = $product['offer_id'] !== null
                ? ($ofertaMap[$product['offer_id']])
                : null;

            unset($product['id']);
            Product::create($product);
        }
    }
}
