<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PernilDeCerdoSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create the product
        $product = Product::firstOrCreate(
            ['name' => 'PERNIL DE CERDO'],
            [
                'slug' => 'pernil-de-cerdo',
                'short_description' => 'El clásico pernil de cerdo, ideal para cualquier festejo.',
                'description' => '',
                'active' => true,
                'featured' => false,
                'order' => 3,
                'category_id' => 1,
            ]
        );

        $variantsData = [
            ['personas' => 10, 'figazzas' => 50, 'price' => 140000],
            ['personas' => 20, 'figazzas' => 100, 'price' => 200000],
            ['personas' => 30, 'figazzas' => 150, 'price' => 270000],
            ['personas' => 40, 'figazzas' => 200, 'price' => 300000],
            ['personas' => 50, 'figazzas' => 250, 'price' => 420000],
            ['personas' => 60, 'figazzas' => 300, 'price' => 520000],
            ['personas' => 70, 'figazzas' => 350, 'price' => 550000],
            ['personas' => 80, 'figazzas' => 400, 'price' => 600000],
            ['personas' => 90, 'figazzas' => 450, 'price' => 640000],
            ['personas' => 100, 'figazzas' => 500, 'price' => 770000],
        ];

        foreach ($variantsData as $index => $data) {
            $description = "INCLUYE\n\nPANES: {$data['figazzas']} figazzas\nSALSAS:\nchimichurri\ncriolla\nalioli\nbarbacoa\ncheddar\ncriolla";

            ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'label' => "{$data['personas']} personas"
                ],
                [
                    'persons' => $data['personas'],
                    'price' => $data['price'],
                    'description' => $description,
                    'order' => $index + 1,
                    'active' => true,
                ]
            );
        }
    }
}
