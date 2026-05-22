<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('label'); // e.g. "20 personas", "50 personas"
            $table->unsignedInteger('persons')->nullable(); // cantidad de personas estimada
            $table->decimal('weight_kg', 8, 2)->nullable(); // peso estimado en kg
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable(); // descripción específica de la variante
            $table->boolean('active')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
