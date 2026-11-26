<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La única vieja era (fecha_cita, hora_cita, estado): el mismo
     * hueco con estado 'confirmado' y otro con 'completado' no la
     * violaba, así que no impedía la doble reserva.
     *
     * Nuevo esquema: columna `slot_activo` ('activo' o NULL).
     * Unique (fecha, hora, slot_activo). En MySQL y SQLite una unique
     * admite varios NULL, así que solo puede haber una cita activa
     * por hueco; las canceladas (NULL) no cuentan. El modelo Citas
     * mantiene la columna: 'activo' al crear/confirmar/completar,
     * NULL al cancelar.
     */
    public function up(): void
    {
        if (Schema::hasColumn('citas', 'slot_activo')) {
            return;
        }

        Schema::table('citas', function (Blueprint $table) {
            $table->dropUnique('unica_cita_activa');
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->string('slot_activo', 20)->nullable()->after('estado');
        });

        DB::statement("UPDATE citas SET slot_activo = 'activo' WHERE estado != 'cancelado'");
        DB::statement('UPDATE citas SET slot_activo = NULL WHERE estado = \'cancelado\'');

        Schema::table('citas', function (Blueprint $table) {
            $table->unique(['fecha_cita', 'hora_cita', 'slot_activo'], 'unica_cita_activa');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropUnique('unica_cita_activa');
            $table->dropColumn('slot_activo');
            $table->unique(['fecha_cita', 'hora_cita', 'estado'], 'unica_cita_activa');
        });
    }
};
