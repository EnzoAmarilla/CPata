<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->string('telefono');
            $table->string('direccion_evento');
            $table->date('fecha_evento');
            $table->time('hora_evento');
            $table->unsignedInteger('cantidad_invitados');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->string('estado')->default('nuevo'); // Enum handled at model level
            $table->text('observaciones_cliente')->nullable();
            $table->text('observaciones_admin')->nullable();
            $table->string('google_calendar_event_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_requests');
    }
};
