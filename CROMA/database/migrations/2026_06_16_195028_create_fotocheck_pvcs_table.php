<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotocheck_pvc', function (Blueprint $table) {
            $table->integer('id_fotocheck')->primary();
            $table->integer('id_detalle');
            $table->string('nombre_titular', 200)->nullable();
            $table->string('cargo', 100)->nullable();
            $table->string('foto_url', 255)->nullable();
            $table->string('institucion', 150)->nullable();
            $table->string('codigo_trabajador', 50)->nullable();

            $table->foreign('id_detalle')
                  ->references('id_detalle')
                  ->on('detalle_pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotocheck_pvc');
    }
};
