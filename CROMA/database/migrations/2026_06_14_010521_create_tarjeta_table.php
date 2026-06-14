<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarjeta', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //$table->unsignedBigInteger('id_detalle');
            $table->string('estilo');
            $table->string('diseno_url');
            $table->string('material')->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('medidas')->nullable();
            //$table->foreign('id_detalle')->references('id_detalle')->on('detalle
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjeta');
    }
};
