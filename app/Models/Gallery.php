<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order'  => 'integer',
    ];
}
