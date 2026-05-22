<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ciudad',
        'texto',
        'rating',
        'active',
        'featured',
        'order',
    ];

    protected $casts = [
        'rating'   => 'integer',
        'active'   => 'boolean',
        'featured' => 'boolean',
        'order'    => 'integer',
    ];
}
