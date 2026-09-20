<?php
namespace App\Enums;

use GuzzleHttp\Exception\ClientException;

enum UserRole: string
{
    case Barber='barber';
    case Cliente= 'Client';

    public function label()
    {
        return match($this){
            self::Barber=>'Barbero',
            self::Cliente=>'Cliente'
        };
    }
}

