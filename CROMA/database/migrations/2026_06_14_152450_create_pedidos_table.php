<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->integer('id_pedido')->primary();
            $table->unsignedBigInteger('id_cliente');
            $table->date('fecha');
            $table->string('estado', 20); // Ej: 'Pendiente', 'Entregado', 'Anulado'
            $table->decimal('total', 10, 2)->nullable();
            $table->longText('observaciones')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();

            $table->foreign('id_cliente')
                  ->references('id')
                  ->on('cliente')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        // Restricción de seguridad: El total no puede ser negativo
        DB::statement('ALTER TABLE pedido ADD CONSTRAINT CHK_pedido_total_valido CHECK (total >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
