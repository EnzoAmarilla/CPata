<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PataDeTerneraSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create the product
        $product = Product::firstOrCreate(
            ['name' => 'PATA DE TERNERA'],
            [
                'slug' => 'pata-de-ternera',
                'short_description' => 'Nuestra exquisita pata de ternera para disfrutar con amigos o familia',
                'description' => '',
                'active' => true,
                'featured' => false,
                'order' => 2,
                'category_id' => 1,
            ]
        );

        $variantsData = [
            ['personas' => 30, 'figazzas' => 150, 'price' => 370000],
            ['personas' => 40, 'figazzas' => 200, 'price' => 410000],
            ['personas' => 50, 'figazzas' => 250, 'price' => 520000],
            ['personas' => 60, 'figazzas' => 300, 'price' => 600000],
            ['personas' => 70, 'figazzas' => 350, 'price' => 740000],
            ['personas' => 80, 'figazzas' => 400, 'price' => 880000],
            ['personas' => 90, 'figazzas' => 450, 'price' => 900000],
            ['personas' => 100, 'figazzas' => 450, 'price' => 999000],
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
                    'order' => $index + 2, // Assuming 20 personas is order 1
                    'active' => true,
                ]
            );
        }
    }
}
