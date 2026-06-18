<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audiovisuals', function (Blueprint $table) {
            $table->integer('id_edicion')->primary();
            $table->integer('id_detalle');
            $table->string('tipo', 30);
            $table->integer('duracion_segundos')->nullable();
            $table->string('archivo_fuente', 255)->nullable();
            $table->string('formato_salida', 50)->nullable();

            $table->foreign('id_detalle')
                  ->references('id_detalle')
                  ->on('detalle_pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE audiovisuals ADD CONSTRAINT CHK_audiovisual_duracion_no_negativa CHECK (duracion_segundos >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('audiovisuals');
    }
};
