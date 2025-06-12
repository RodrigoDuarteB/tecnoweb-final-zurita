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
        Schema::table('servicio_pago', function (Blueprint $table) {
             $table->foreignId('obligacion_id')->nullable()->constrained('obligacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicio_pago', function (Blueprint $table) {
            $table->dropColumn('obligacion_id');
        });
    }
};
