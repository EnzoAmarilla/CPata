<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ── PERNILES ──────────────────────────────────────────────
        $catPerniles = Category::where('slug', 'perniles')->first();

        $pernil = Product::updateOrCreate(
            ['slug' => 'pernil-de-cerdo'],
            [
                'category_id'       => $catPerniles->id,
                'name'              => 'Pernil de Cerdo',
                'slug'              => 'pernil-de-cerdo',
                'short_description' => 'Pernil de cerdo al horno, tierno y jugoso. La estrella de cualquier evento.',
                'description'       => 'Nuestro pernil de cerdo se cocina lentamente durante horas con hierbas aromáticas y especias seleccionadas, logrando una carne tierna, jugosa y con una piel dorada y crocante. Perfecto para celebraciones, cumpleaños, casamientos y eventos empresariales.',
                'active'            => true,
                'featured'          => true,
                'order'             => 1,
            ]
        );

        $this->createVariants($pernil->id, [
            ['label' => '20 personas',  'persons' => 20,  'weight_kg' => 4.0,  'price' => 45000,  'order' => 1],
            ['label' => '30 personas',  'persons' => 30,  'weight_kg' => 6.0,  'price' => 65000,  'order' => 2],
            ['label' => '50 personas',  'persons' => 50,  'weight_kg' => 10.0, 'price' => 100000, 'order' => 3],
            ['label' => '100 personas', 'persons' => 100, 'weight_kg' => 20.0, 'price' => 180000, 'order' => 4],
        ]);

        // Paleta de cerdo
        $paleta = Product::updateOrCreate(
            ['slug' => 'paleta-de-cerdo'],
            [
                'category_id'       => $catPerniles->id,
                'name'              => 'Paleta de Cerdo',
                'slug'              => 'paleta-de-cerdo',
                'short_description' => 'Paleta de cerdo al horno, jugosa y sabrosa. Ideal para eventos medianos.',
                'description'       => 'La paleta de cerdo cocida al horno con nuestras especias secretas. Una opción más económica que el pernil, sin sacrificar sabor ni calidad.',
                'active'            => true,
                'featured'          => false,
                'order'             => 2,
            ]
        );

        $this->createVariants($paleta->id, [
            ['label' => '15 personas', 'persons' => 15, 'weight_kg' => 3.0, 'price' => 32000, 'order' => 1],
            ['label' => '25 personas', 'persons' => 25, 'weight_kg' => 5.0, 'price' => 52000, 'order' => 2],
            ['label' => '40 personas', 'persons' => 40, 'weight_kg' => 8.0, 'price' => 80000, 'order' => 3],
        ]);

        // ── ASADOS ────────────────────────────────────────────────
        $catAsados = Category::where('slug', 'asados-parrilla')->first();

        $asado = Product::updateOrCreate(
            ['slug' => 'asado-completo'],
            [
                'category_id'       => $catAsados->id,
                'name'              => 'Asado Completo',
                'slug'              => 'asado-completo',
                'short_description' => 'Asado completo con vacío, costillas, chorizos y morcillas. Para verdaderos amantes del asado.',
                'description'       => 'Asado completo con cortes seleccionados: vacío, costillas, tira de asado, chorizos, morcillas y achuras. Incluye pan, ensaladas y salsas. El asador va al lugar del evento.',
                'active'            => true,
                'featured'          => true,
                'order'             => 1,
            ]
        );

        $this->createVariants($asado->id, [
            ['label' => '20 personas', 'persons' => 20, 'price' => 55000,  'order' => 1],
            ['label' => '30 personas', 'persons' => 30, 'price' => 80000,  'order' => 2],
            ['label' => '50 personas', 'persons' => 50, 'price' => 130000, 'order' => 3],
            ['label' => '80 personas', 'persons' => 80, 'price' => 200000, 'order' => 4],
        ]);

        // ── EMPANADAS ─────────────────────────────────────────────
        $catEmpanadas = Category::where('slug', 'empanadas')->first();

        $empanadas = Product::updateOrCreate(
            ['slug' => 'empanadas-artesanales'],
            [
                'category_id'       => $catEmpanadas->id,
                'name'              => 'Empanadas Artesanales',
                'slug'              => 'empanadas-artesanales',
                'short_description' => 'Empanadas caseras en variedades a elección. Carne, pollo, verdura, humita y más.',
                'description'       => 'Empanadas artesanales elaboradas diariamente con masa casera. Disponibles en: carne cortada a cuchillo, pollo, verdura, humita, jamón y queso, y caprese. Se entregan listas para hornear o ya horneadas.',
                'active'            => true,
                'featured'          => false,
                'order'             => 1,
            ]
        );

        $this->createVariants($empanadas->id, [
            ['label' => 'Docena (12 unidades)',     'persons' => 4,  'price' => 8500,  'order' => 1],
            ['label' => '3 docenas (36 unidades)',  'persons' => 12, 'price' => 24000, 'order' => 2],
            ['label' => '5 docenas (60 unidades)',  'persons' => 20, 'price' => 38000, 'order' => 3],
            ['label' => '10 docenas (120 unidades)','persons' => 40, 'price' => 70000, 'order' => 4],
        ]);

        // ── BUFFET ────────────────────────────────────────────────
        $catBuffet = Category::where('slug', 'buffet-completo')->first();

        $buffet = Product::updateOrCreate(
            ['slug' => 'buffet-completo-evento'],
            [
                'category_id'       => $catBuffet->id,
                'name'              => 'Buffet Completo para Eventos',
                'slug'              => 'buffet-completo-evento',
                'short_description' => 'Servicio completo de catering: pernil + ensaladas + pan + bebidas. Todo incluido.',
                'description'       => 'Nuestro paquete buffet completo incluye: pernil de cerdo o asado a elección, ensaladas variadas (3 tipos), pan artesanal, salsas, vajilla descartable premium y bebidas (agua y gaseosas). El personal se encarga de la presentación y el servicio.',
                'active'            => true,
                'featured'          => true,
                'order'             => 1,
            ]
        );

        $this->createVariants($buffet->id, [
            ['label' => '30 personas',  'persons' => 30,  'price' => 120000, 'order' => 1],
            ['label' => '50 personas',  'persons' => 50,  'price' => 190000, 'order' => 2],
            ['label' => '80 personas',  'persons' => 80,  'price' => 280000, 'order' => 3],
            ['label' => '100 personas', 'persons' => 100, 'price' => 340000, 'order' => 4],
        ]);
    }

    /**
     * Create variants for a product, skipping existing ones by label.
     */
    private function createVariants(int $productId, array $variants): void
    {
        foreach ($variants as $variant) {
            ProductVariant::updateOrCreate(
                ['product_id' => $productId, 'label' => $variant['label']],
                array_merge($variant, ['product_id' => $productId, 'active' => true])
            );
        }
    }
}
