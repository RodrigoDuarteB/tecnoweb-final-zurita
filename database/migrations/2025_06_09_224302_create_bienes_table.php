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
       Schema::create('bien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('cliente')->onDelete('cascade');
            $table->foreignId('tipo_bien_id')->constrained('tipo_bien')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('valor_referencial', 12, 2)->default(0);
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bien');
    }
};
