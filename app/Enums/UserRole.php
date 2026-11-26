<?php

namespace App\Enums;

enum UserRole: string
{
    case Barber = 'barber';
    case Cliente = 'cliente';

    public function label(): string
    {
        return match ($this) {
            self::Barber => 'Barbero',
            self::Cliente => 'Cliente',
        };
    }
}
