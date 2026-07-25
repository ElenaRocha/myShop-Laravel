<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::all()->each(function (Supplier $supplier): void {
            // Enlaza al proveedor ya creado; si no se fija supplier_id aquí,
            // AddressFactory generaría uno nuevo con Supplier::factory().
            Address::factory()->create(['supplier_id' => $supplier->id]);
        });
    }
}
