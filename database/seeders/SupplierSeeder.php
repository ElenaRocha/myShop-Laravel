<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = $this->getSuppliers();

        foreach ($suppliers as $supplier) {
            Supplier::create([
                'name' => $supplier['name'],
                'email' => $supplier['email'],
                // 'contact_person' => $supplier['contact_person'],
                // 'phone' => $supplier['phone'],
            ]);
        }
    }
}
