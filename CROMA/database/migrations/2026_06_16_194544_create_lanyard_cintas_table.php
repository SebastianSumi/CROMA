<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lanyard_cinta', function (Blueprint $table) {
            $table->integer('id_lanyard')->primary();
            $table->integer('id_detalle');
            $table->string('color', 50)->nullable();
            $table->string('texto_impreso', 200)->nullable();

            $table->foreign('id_detalle')
                  ->references('id_detalle')
                  ->on('detalle_pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lanyard_cinta');
    }
};
