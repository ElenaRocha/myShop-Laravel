<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class BrandSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $brands = Brand::all();

        if ($suppliers->isEmpty() || $brands->isEmpty()) {
            return;
        }

        // Enlaza cada proveedor ya creado con 1 o 2 marcas ya creadas (N:M),
        // rotando sobre el catálogo de marcas para no duplicar el mismo par.
        $suppliers->each(function (Supplier $supplier, int $index) use ($brands): void {
            $primary = $brands[$index % $brands->count()]->id;
            $secondary = $brands[($index + 1) % $brands->count()]->id;

            $supplier->brands()->attach(array_unique([$primary, $secondary]));
        });
    }
}
