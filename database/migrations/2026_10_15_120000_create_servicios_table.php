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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 8, 2)->default(0);
            $table->unsignedSmallInteger('duracion')->default(30); // duración en minutos
            $table->timestamps();
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->string('email_cliente')->nullable()->after('phone_cliente');
            $table->foreignId('servicio_id')->nullable()->after('nota')
                ->constrained('servicios')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('servicio_id');
            $table->dropColumn('email_cliente');
        });

        Schema::dropIfExists('servicios');
    }
};
