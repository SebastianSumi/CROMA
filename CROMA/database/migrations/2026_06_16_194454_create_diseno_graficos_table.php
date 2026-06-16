<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diseno_grafico', function (Blueprint $table) {
            $table->integer('id_diseno')->primary();
            $table->integer('id_detalle');
            $table->string('tipo', 30); // Ej: 'Logotipo', 'Flyer', 'Identidad Visual'
            $table->string('arch_fuente_url', 255)->nullable();
            $table->string('estado_aprobacion', 20); // Ej: 'En proceso', 'Aprobado', 'Rechazado'
            $table->string('arch_result_url', 255);

            $table->foreign('id_detalle')
                  ->references('id_detalle')
                  ->on('detalle_pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diseno_grafico');
    }
};
