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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::create('accion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('es_menu')->default(false); // Define si es menú
            $table->string('url')->nullable();         // URL solo si es menú
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        Schema::create('permiso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->constrained('rol')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menu')->onDelete('cascade');
            $table->foreignId('accion_id')->constrained('accion')->onDelete('cascade');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->unique(['rol_id', 'menu_id', 'accion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
