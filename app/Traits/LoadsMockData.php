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
     * Load products from mock file
     */
    protected function getProducts(): array
    {
        return require database_path('data/mock-products.php');
    }

    /**
     * Load favorites from mock file
     */
    protected function getFavorites(): array
    {
        return require database_path('data/mock-favorites.php');
    }

    /**
     * Load brands from mock file
     */
    protected function getBrands(): array
    {
        return require database_path('data/mock-brands.php');
    }

    /**
     * Load suppliers from mock file
     */
    protected function getSuppliers(): array
    {
        return require database_path('data/mock-suppliers.php');
    }
}