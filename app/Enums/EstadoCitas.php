<?php

namespace App\Enums;

enum EstadoCitas: string
{
   case Cancelado='cancelado';
   case Completado='completado';
   case Confirmado='confirmado';

   //para mostrar en la vista
   public function label()
   {
    return match($this)
    {
        self::Cancelado=>'cancelado',
        self::Completado=>'completado',
        self::Confirmado=>'confirmado'
    };
   }

   //para el color
   public function color()
   {
    return match($this){
        self::Cancelado=>'red',
        self::Completado=>'blue',
        self::Confirmado=>'green'      
    };
   }
}
