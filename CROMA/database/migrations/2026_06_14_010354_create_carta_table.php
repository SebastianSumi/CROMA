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
        Schema::create('carta', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //$table->unsignedBigInteger('id_detalle');
            $table->integer('num_paginas')->nullable();
            $table->string('tipo_material')->nullable();
            $table->string('diseno_url')->nullable();
            $table->boolean('incluye_fotos')->default(false);
            //$table->foreign('id_detalle')->references('id_detalle')->on('detalle')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta');
    }
};
