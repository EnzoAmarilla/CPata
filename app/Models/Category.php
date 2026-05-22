<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order'  => 'integer',
    ];

    /**
     * Get all products in this category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('order');
    }

    /**
     * Get only active products in this category.
     */
    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('active', true)->orderBy('order');
    }
}
