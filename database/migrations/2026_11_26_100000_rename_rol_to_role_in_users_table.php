<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La migración original creó la columna `rol` (default 'cliente')
     * pero el modelo User usa `role` con el enum UserRole
     * ('barber' / 'cliente'). Sin esta migración isBarber() era
     * siempre falso. Se añade `role`, se copian los valores y se
     * elimina `rol`. Sin doctrine/dbal: añadir + copiar + borrar.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('cliente')->after('password');
            });

            if (Schema::hasColumn('users', 'rol')) {
                // Normalizar valores viejos: 'Client' -> 'cliente'.
                DB::statement("UPDATE users SET role = LOWER(rol)");
                DB::statement("UPDATE users SET role = 'cliente' WHERE role NOT IN ('barber', 'cliente')");
            }
        }

        if (Schema::hasColumn('users', 'rol')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('rol');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'rol')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('rol')->default('cliente')->after('password');
            });
            DB::statement('UPDATE users SET rol = role');
        }

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
