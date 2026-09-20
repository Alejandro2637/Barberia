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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('name_cliente');
            $table->string('phone_cliente',20);
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('estado')->default('confirmado');//cancelar / confirmado / completado
            $table->string('cancelacion',64)->nullable()->unique();
            $table->timestamp('cancelado_at')->nullable();
            $table->text('nota')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->unique(['fecha_cita','hora_cita','estado'],'unica_cita_activa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
