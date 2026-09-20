<?php

namespace App\Models;

use Carbon\Carbon;
use Collator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class horario_barberias extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table='horario_barberia';

    protected $fillable = [
        'dias_semana',
        'start_dia',
        'end_dia',
        'open',
        'duracion'
    ];

    public function casts():array{
        return[
            'start_dia'=>'datetime:H:i',
            'end_dia'=>'datetime:H:i',
            'estado'=>'boolean',
        ];
    }

    public function generarHorario(){
        $horario=[];
        $inicio=Carbon::parse($this->start_dia);
        $fin=Carbon::parse($this->end_dia);

        while($inicio<$fin){
            $horario[]=$inicio->format('H:i');
            $inicio->addMinute($this->duracion);
        }
        return $horario;
    }
    
    
}
