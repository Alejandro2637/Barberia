<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vacacioness extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'razon'
    ];

     public function casts():array{
        return[
            'fecha'=>'date',
        ];
     }
}
