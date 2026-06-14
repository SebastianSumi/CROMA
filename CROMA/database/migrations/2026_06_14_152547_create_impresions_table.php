<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impresions', function (Blueprint $table) {
            $table->integer('id_impresion')->primary();
            $table->integer('id_detalle');
            $table->string('tipo_documento', 30);
            $table->string('tipo_papel', 30);
            $table->string('tipo_tinta', 30);
            $table->string('formato', 20)->nullable();
            $table->string('diseno_url', 255);

            $table->foreign('id_detalle')
                  ->references('id_detalle')
                  ->on('detalle_pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impresion');
    }
};
