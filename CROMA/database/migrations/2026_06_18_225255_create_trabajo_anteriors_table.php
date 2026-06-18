<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajos_anteriores', function (Blueprint $table) {
            $table->id('id_trabajo');
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('imagen_url'); // Obligatorio, es la foto de la muestra
            $table->integer('producto_id')->nullable(); // Para saber de qué producto es la muestra
            $table->date('fecha_realizacion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajos_anteriores');
    }
};
