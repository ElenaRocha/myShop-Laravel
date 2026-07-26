<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = $this->getBrands();

        foreach ($brands as $brand) {
            unset($brand['id']);
            Brand::create($brand);
        }
    }
}
