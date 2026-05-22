<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Perniles',
                'slug'        => 'perniles',
                'description' => 'Perniles de cerdo al horno, la especialidad de la casa.',
                'icon'        => '🍖',
                'order'       => 1,
            ],
            [
                'name'        => 'Asados y Parrilla',
                'slug'        => 'asados-parrilla',
                'description' => 'Asados completos y parrilladas para eventos y reuniones.',
                'icon'        => '🔥',
                'order'       => 2,
            ],
            [
                'name'        => 'Empanadas',
                'slug'        => 'empanadas',
                'description' => 'Empanadas artesanales en variedades de carne, pollo, verdura y más.',
                'icon'        => '🥟',
                'order'       => 3,
            ],
            [
                'name'        => 'Buffet Completo',
                'slug'        => 'buffet-completo',
                'description' => 'Servicio completo de catering con múltiples opciones.',
                'icon'        => '🍽️',
                'order'       => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
