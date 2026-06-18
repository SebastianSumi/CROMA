<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicio_offset', function (Blueprint $table) {
            $table->integer('id_offset')->primary();
            $table->integer('id_detalle');
            $table->string('tipo_material', 30);
            $table->integer('num_paginas')->nullable();
            $table->string('acabado', 100)->nullable();
            $table->string('diseno_url', 255);

            $table->foreign('id_detalle')
                  ->references('id_detalle')
                  ->on('detalle_pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE servicio_offset ADD CONSTRAINT CHK_offset_paginas_validas CHECK (num_paginas > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio_offset');
    }
};
