<?php

namespace App\Traits;

trait LoadsMockData
{
    /**
     * Load categories from mock file
     */
    protected function getCategories(): array
    {
        return require database_path('data/mock-categories.php');
    }

    /**
     * Load offers from mock file
     */
    protected function getOffers(): array
    {
        return require database_path('data/mock-offers.php');
    }

    /**
     * Load favorites from mock file
     */
    protected function getFavorites(): array
    {
        return require database_path('data/mock-favorites.php');
    }

    /**
     * Load products from mock file
     */
    protected function getProducts(): array
    {
        return require database_path('data/mock-products.php');
    }

    /**
     * Load brands from mock file
     */
    protected function getBrands(): array
    {
        return require database_path('data/mock-brands.php');
    }

    /**
     * Load all mock data at once
     */
    protected function getAllMockData(): array
    {
        return [
            'categories' => $this->getCategories(),
            'offers' => $this->getOffers(),
            'favorites' => $this->getFavorites(),
            'products' => $this->getProducts(),
            'brands' => $this->getBrands(),
        ];
    }

    /**
     * Enrich products with their offer data and calculate final price
     * This method adds 'offer' and 'final_price' to each product that has an offer
     */
    protected function enrichProductsWithOffers(array $products): array
    {
        $offers = $this->getOffers();
        
        // array_map() recorre un array y devuelve uno nuevo aplicando la función
        // a cada elemento. Aquí transformamos cada producto en una versión enriquecida.
        return array_map(function($product) use ($offers) {
            // Add offer data if product has an offer
            if ($product['offer_id'] !== null && isset($offers[$product['offer_id']])) {
                $offer = $offers[$product['offer_id']];
                $product['offer'] = $offer;
                
                // Calculate final price with discount
                $discount = $product['price'] * ($offer['discount_percentage'] / 100);
                $product['final_price'] = $product['price'] - $discount;
            } else {
                $product['offer'] = null;
                $product['final_price'] = $product['price'];
            }
            
            return $product;
        }, $products);
    }
}