<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicio', function (Blueprint $table) {
            $table->integer('id_servicio')->primary();
            $table->string('nombre_servicio', 100);
            $table->longText('descripcion')->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->boolean('activo')->default(true);
        });

        DB::statement('ALTER TABLE servicio ADD CONSTRAINT CHK_servicio_precio_positivo CHECK (precio_base >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
