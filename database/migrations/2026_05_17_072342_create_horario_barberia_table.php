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
        Schema::create('horario_barberia', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('dias_semana');
            $table->time('start_dia');
            $table->time('end_dia');
            $table->boolean('open')->default(true);
            $table->unsignedSmallInteger('duracion')->default(15);
            $table->unique('dias_semana');
            $table->timestamps();
          //agregar hora inicio , verificar en la tabla
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_barberia');
    }
};
