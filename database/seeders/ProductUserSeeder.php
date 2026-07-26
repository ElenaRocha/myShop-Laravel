<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class ProductUserSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favoriteItems = $this->getFavorites();

        $user = User::first();

        if (! $user) {
            return;
        }

        $mockProducts = $this->getProducts();

        $productosDb = Product::with('offer')->get();
        $idToProduct = [];
        foreach ($mockProducts as $mockProduct) {
            $productoReal = $productosDb->where('name', $mockProduct['name'])->first();
            if ($productoReal) {
                $idToProduct[$mockProduct['id']] = $productoReal;
            }
        }

        foreach ($favoriteItems as $item) {
            $producto = $idToProduct[$item['product_id']] ?? null;
            if ($producto === null) {
                continue;
            }

            $user->favorites()->attach($producto->id, [
                'price_at_add' => $producto->final_price,
            ]);
        }
    }
}
