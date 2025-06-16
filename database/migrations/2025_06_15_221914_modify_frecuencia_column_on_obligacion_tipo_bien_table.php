<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE "obligacion_tipo_bien" ALTER COLUMN "frecuencia" TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE "obligacion_tipo_bien" DROP CONSTRAINT "obligacion_tipo_bien_frecuencia_check"');
        DB::statement('ALTER TABLE "obligacion_tipo_bien" ADD CONSTRAINT "obligacion_tipo_bien_frecuencia_check" CHECK ("frecuencia" IN (\'Diaria\', \'Semanal\', \'Quincenal\', \'Mensual\', \'Anual\', \'UnaVez\'))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE "obligacion_tipo_bien" DROP CONSTRAINT "frecuencia_check"');
        DB::statement('ALTER TABLE "obligacion_tipo_bien" ALTER COLUMN "frecuencia" TYPE TEXT');
    }
};
