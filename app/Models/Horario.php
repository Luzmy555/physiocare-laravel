<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'fisioterapeuta_id',
        'dia',
        'disponible',
        'hora_inicio',
        'hora_fin',
    ];

    // Relación con Fisioterapeuta
    public function fisioterapeuta()
    {
        return $this->belongsTo(Fisioterapeuta::class);
    }
}
