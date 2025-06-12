<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obligacion_tipo_bien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_bien_id')
                ->constrained('tipo_bien')
                ->onDelete('cascade');
            $table->string('nombre', 100);
            $table->enum('tipo', ['Impuesto', 'Tasa', 'Multa', 'Otro']);
            $table->decimal('precio', 15, 2)->default(0);
            $table->enum('frecuencia', ['Diaria', 'Semanal', 'Quincenal', 'Mensual', 'Anual']);
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obligacion_tipo_bien');
    }
};
