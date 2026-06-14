<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->integer('id_pago')->primary();
            $table->integer('id_pedido');
            $table->decimal('monto', 10, 2);
            $table->timestamp('fecha_pago')->useCurrent();

            $table->foreign('id_pedido')
                  ->references('id_pedido')
                  ->on('pedido')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE pago ADD CONSTRAINT CHK_pago_monto_positivo CHECK (monto > 0.00)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
