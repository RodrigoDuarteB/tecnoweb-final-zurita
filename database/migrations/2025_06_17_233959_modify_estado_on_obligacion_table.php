<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE "obligacion" ALTER COLUMN "estado" TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE "obligacion" DROP CONSTRAINT "obligacion_estado_check"');
        DB::statement('ALTER TABLE "obligacion" ADD CONSTRAINT
        "obligacion_estado_check" CHECK ("estado" IN (\'Pendiente\', \'Pagada\', \'Vencida\', \'Cancelada\'))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
