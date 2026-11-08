<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            ['nombre' => 'Corte de cabello', 'precio' => 300, 'duracion' => 30],
            ['nombre' => 'Arreglo de barba', 'precio' => 200, 'duracion' => 20],
            ['nombre' => 'Combo completo', 'precio' => 500, 'duracion' => 45],
        ];

        foreach ($servicios as $servicio) {
            Servicio::updateOrCreate(
                ['nombre' => $servicio['nombre']],
                $servicio
            );
        }
    }
}
