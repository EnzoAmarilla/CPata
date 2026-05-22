<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'images',
        'active',
        'featured',
        'order',
    ];

    protected $casts = [
        'images'   => 'array',
        'active'   => 'boolean',
        'featured' => 'boolean',
        'order'    => 'integer',
    ];

    /**
     * The category this product belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * All variants of this product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('order');
    }

    /**
     * Only active variants.
     */
    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)
            ->where('active', true)
            ->orderBy('order');
    }

    /**
     * Event requests that used this product.
     */
    public function eventRequests(): HasMany
    {
        return $this->hasMany(EventRequest::class);
    }

    /**
     * Get the first active variant (for default display).
     */
    public function getDefaultVariantAttribute(): ?ProductVariant
    {
        return $this->activeVariants()->first();
    }
}
