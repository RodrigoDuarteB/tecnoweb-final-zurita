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
        Schema::create('pago_obligacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obligacion_id')->constrained('obligacion')->onDelete('cascade');
            $table->foreignId('pago_id')->constrained('pago')->onDelete('cascade');
            $table->decimal('monto_obligacion', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_obligacion');
    }
};
