<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'discount_percentage', 'description'])]
class Offer extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the products that have this offer.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}