<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();

        if ($suppliers->isEmpty()) {
            return;
        }

        Product::inRandomOrder()->limit(10)->get()->each(
            fn (Product $product, int $index) => $product->update([
                'supplier_id' => $suppliers[$index % $suppliers->count()]->id,
            ])
        );
    }
}
