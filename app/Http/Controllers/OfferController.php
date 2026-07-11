<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfferController extends Controller
{
    use LoadsMockData;

    /**
     * Show all offers
     */
    public function index(): View
    {
        $offers = $this->getOffers();
        
        return view('offers.index', ['offers' => $offers]);
    }

    /**
     * Show products with a specific offer
     */
    public function show(string $offer): View
    {
        $offers = $this->getOffers();
        
        // Find offer by ID (devuelve null si la clave no existe)
        $offerId = $offer;
        $offer = $offers[$offerId] ?? null;
        
        if (!$offer) {
            abort(404, 'Oferta no encontrada');
        }
        
        // Load and enrich products
        $products = $this->getProducts();
        
        // Filter products by offer (un producto solo puede tener una oferta)
        $offerProducts = array_filter($products, function($product) use ($offerId) {
            return $product['offer_id'] == $offerId;
        });
        
        $offerProducts = $this->enrichProductsWithOffers($offerProducts);

        return view('offers.show', compact('offer', 'offerProducts'));
    }
}