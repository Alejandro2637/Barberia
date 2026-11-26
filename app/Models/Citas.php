<?php

namespace App\Models;

use App\Enums\EstadoCitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class Citas extends Model
{
    use HasFactory;

    /**
     * Solo lo que el cliente puede aportar. `estado`, `cancelacion`,
     * `cancelado_at`, `user_id` y `slot_activo` NUNCA vienen del
     * request: los fija el servidor (ver boot / cancelar / store).
     */
    protected $fillable = [
        'name_cliente',
        'email_cliente',
        'phone_cliente',
        'fecha_cita',
        'hora_cita',
        'nota',
        'servicio_id',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'fecha_cita' => 'date',
            'hora_cita' => 'time',
            'estado' => EstadoCitas::class,
            'cancelado_at' => 'datetime',
        ];
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        // Toda cita nueva ocupa su hueco: slot_activo = 'activo'.
        // Al cancelar se pone a NULL y el hueco queda libre
        // (ver la unique de la migración 2026_11_26_100001).
        static::creating(function (Citas $cita) {
            $cita->slot_activo = 'activo';
        });
    }

    protected $attributes = ['estado' => 'confirmado'];

    public static function horarioDisponible($fecha, $hora, $exceptoId = null)
    {
        $q = self::whereFechaCita($fecha)->whereHoraCita($hora)->where('estado', '!=', EstadoCitas::Cancelado->value);
        if ($exceptoId) {
            $q->where('id', '!=', $exceptoId);
        }
        $existe = $q->exists();

        return ! $existe;
    }

    //cambiar estado a completado
    public function completar(): void
    {
        $this->update([
            'estado' => EstadoCitas::Completado->value,
            'slot_activo' => 'activo',
        ]);
    }

    //cambiar estado a cancelado: libera el hueco.
    public function cancelar(string $motivo = null): void
    {
        $this->update([
            'estado' => EstadoCitas::Cancelado->value,
            'nota' => $motivo,
            'cancelado_at' => now(),
            'slot_activo' => null,
        ]);
    }

    //cambiar estado a confirmado
    public function confirmar(): void
    {
        $this->update([
            'estado' => EstadoCitas::Confirmado->value,
            'slot_activo' => 'activo',
        ]);
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
