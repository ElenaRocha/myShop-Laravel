<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = $this->getOffers();

        foreach ($offers as $offer) {
            unset($offer['id']); // descarta el id numérico del mock; HasUuids genera el UUID
            Offer::create($offer);
        }
    }
}
