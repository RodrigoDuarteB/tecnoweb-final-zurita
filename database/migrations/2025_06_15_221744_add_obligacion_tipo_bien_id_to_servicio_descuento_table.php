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
        Schema::table('servicio_descuento', function (Blueprint $table) {
            $table->foreignId('obligacion_tipo_bien_id')->nullable()->constrained('obligacion_tipo_bien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicio_descuento', function (Blueprint $table) {
            $table->dropConstrainedForeignId('obligacion_tipo_bien_id');
            $table->dropColumn('obligacion_tipo_bien_id');
        });
    }
};
