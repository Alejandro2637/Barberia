<?php

namespace App\Console\Commands;

use App\Enums\EstadoCitas;
use App\Mail\RecordatorioCita;
use App\Models\Citas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatorios extends Command
{
    protected $signature = 'citas:recordatorios';

    protected $description = 'Envía por email el recordatorio de las citas de mañana';

    public function handle(): int
    {
        $manana = now()->addDay()->toDateString();

        $citas = Citas::with('servicio')
            ->whereDate('fecha_cita', $manana)
            ->where('estado', EstadoCitas::Confirmado->value)
            ->whereNotNull('email_cliente')
            ->get();

        $enviados = 0;
        foreach ($citas as $cita) {
            try {
                Mail::to($cita->email_cliente)->send(new RecordatorioCita(
                    $cita,
                    route('citas.cancelar.enlace', ['token' => $cita->cancelacion]),
                    route('citas.reprogramar.enlace', ['token' => $cita->cancelacion]),
                ));
                $enviados++;
            } catch (\Throwable $e) {
                $this->error("No se pudo enviar a {$cita->email_cliente}: {$e->getMessage()}");
            }
        }

        $this->info("Recordatorios enviados: {$enviados} de {$citas->count()}");

        return self::SUCCESS;
    }
}
