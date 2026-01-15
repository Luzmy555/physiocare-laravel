<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'fisioterapeuta_id',
        'fecha_cita',
        'hora_cita',
        'motivo',
        'estado'
    ];

    // Relación con paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con fisioterapeuta
    public function fisioterapeuta()
    {
        return $this->belongsTo(Fisioterapeuta::class);
    }
}
