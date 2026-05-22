<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class CombinadoSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create the product
        $product = Product::firstOrCreate(
            ['name' => 'COMBINADO (CERDO+TERNERA)'],
            [
                'slug' => 'combinado-cerdo-ternera',
                'short_description' => 'La mejor combinación para tu evento',
                'description' => '',
                'active' => true,
                'featured' => false,
                'order' => 1,
                'category_id' => 1,
            ]
        );

        $variantsData = [
            ['personas' => 40, 'figazzas' => 250, 'price' => 500000],
            ['personas' => 50, 'figazzas' => 250, 'price' => 580000],
            ['personas' => 60, 'figazzas' => 300, 'price' => 645000],
            ['personas' => 70, 'figazzas' => 350, 'price' => 690000],
            ['personas' => 80, 'figazzas' => 400, 'price' => 720000],
            ['personas' => 90, 'figazzas' => 450, 'price' => 845000],
            ['personas' => 100, 'figazzas' => 500, 'price' => 900000],
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
