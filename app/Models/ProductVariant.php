<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'label',
        'persons',
        'weight_kg',
        'price',
        'description',
        'active',
        'order',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'weight_kg' => 'decimal:2',
        'persons'   => 'integer',
        'active'    => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * The product this variant belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted price in Argentine pesos.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 0, ',', '.');
    }
}
