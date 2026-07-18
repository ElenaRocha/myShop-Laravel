<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = $this->getCategories();

        foreach ($categories as $category) {
            unset($category['id']); // descarta el id numérico del mock; HasUuids genera el UUID
            Category::create($category);
        }
    }
}