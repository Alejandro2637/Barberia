<?php

namespace App\Models;

use App\Enums\EstadoCitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Str; 
use Override;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
       'name_cliente',
       'phone_cliente',
       'fecha_cita',
       'hora_cita',
       'estado',
       'cancelacion',
       'cancelado_at',
       'nota',
       'user_id',

    ];

    #[Override]
    protected function casts(): array
    {
        return[
            'fecha_cita'=>'date',
            'hora_cita'=>'time',
            'estado'=>EstadoCitas::class,
            'cancelado-at'=>'datetime',

        ];
    }

    #[Override]
    protected static function boot():void
    {
         parent::boot();

    }

    protected $attributes = ['estado'=>'confirmado'];

    public static function horarioDisponible( $fecha, $hora){
       $existe=self::whereFechaCita($fecha)->whereHoraCita($hora)->where('estado','!=',EstadoCitas::Cancelado->value)->exists;
       return !$existe;
    }

    //cambiar estado a completado
    public function completar():void
    {
        $this->update([
            'estado'=>EstadoCitas::Completado->value            
        ]);
    }
     
    //cambiar estado a cancelado
    public function cancelar(string $motivo=null):void
    {
        $this->update([
            'estado'=>EstadoCitas::Cancelado->value 
            'nota'=>$motivo    //cambiar nota a string en la base de datos    
        ]);
    }

    //cambiar estado a confirmado
    public function confirmar():void
    {
        $this->update([
            'estado'=>EstadoCitas::Confirmado->value 
        ]);
    }
}