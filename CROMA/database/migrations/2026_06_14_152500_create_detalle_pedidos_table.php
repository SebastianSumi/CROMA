<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->integer('id_detalle')->primary();
            $table->integer('id_pedido');
            $table->integer('id_servicio');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2)->nullable();

            $table->foreign('id_pedido')
                  ->references('id_pedido')
                  ->on('pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_servicio')
                  ->references('id_servicio')
                  ->on('servicio')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE detalle_pedido ADD CONSTRAINT CHK_detalle_cantidad CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE detalle_pedido ADD CONSTRAINT CHK_detalle_precio CHECK (precio_unitario >= 0)');
        DB::statement('ALTER TABLE detalle_pedido ADD CONSTRAINT CHK_detalle_subtotal CHECK (subtotal >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};
