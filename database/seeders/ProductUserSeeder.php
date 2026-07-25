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

        // Obtener el primer usuario. Si aún no hay usuarios (por ejecutar este
        // seeder de forma aislada), no hay a quién asignar favoritos: salimos.
        $user = User::first();

        if (! $user) {
            return;
        }

        // Cargamos los productos de los mocks
        $mockProducts = $this->getProducts();

        // Cargamos todos los productos de la BD con sus ofertas para poder calcular el precio final
        $productosDb = Product::with('offer')->get();
        $idToProduct = [];
        foreach ($mockProducts as $mockProduct) {
            // Buscamos el producto real en la BD por su nombre
            $productoReal = $productosDb->where('name', $mockProduct['name'])->first();
            if ($productoReal) {
                // Asignamos el producto real al id del mock para poder traducirlo después
                $idToProduct[$mockProduct['id']] = $productoReal;
            }
        }

        foreach ($favoriteItems as $item) {
            // Traduce el product_id numérico del mock a su producto real
            $producto = $idToProduct[$item['product_id']] ?? null;
            if ($producto === null) {
                continue; // El producto no existe en la BD
            }

            // Añadir el producto a favoritos con el precio final al momento de añadirlo
            $user->favorites()->attach($producto->id, [
                'price_at_add' => $producto->final_price,
            ]);
        }
    }
}
