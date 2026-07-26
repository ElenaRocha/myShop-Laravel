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
            Address::factory()->create(['supplier_id' => $supplier->id]);
        });
    }
}
