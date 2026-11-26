<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'duracion',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'duracion' => 'integer',
        ];
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Citas::class);
    }

    /**
     * Busca un servicio a partir del texto que envía el formulario clásico
     * (ej. "Corte de cabello - $300" o "Corte de cabello").
     */
    public static function desdeTexto(?string $texto): ?self
    {
        if (! $texto) {
            return null;
        }

        $nombre = trim(preg_replace('/\s*-\s*\$?\s*[\d.,]+$/', '', $texto));

        // Igualdad exacta primero. El fallback LIKE escapa % _ y \
        // para que no actúen como comodines y resuelvan otro servicio.
        $escapado = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $nombre);

        return static::where('nombre', $nombre)->first()
            ?? static::where('nombre', 'like', '%'.$escapado.'%')->first();
    }
}
