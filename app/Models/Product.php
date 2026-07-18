<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'description', 'price', 'stock', 'is_active', 'category_id', 'offer_id'])]
class Product extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the offer that applies to this product.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get the users who have this product in their favorites (N:M relationship).
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user')
            ->withPivot('price_at_add')
            ->withTimestamps();
    }

    /**
     * Get the product's final price after applying discounts.
     */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->offer && $this->offer->discount_percentage > 0) {
                    $discount = $this->price * ($this->offer->discount_percentage / 100);
                    return round($this->price - $discount, 2);
                }
                return $this->price;
            },
        );
    }
}