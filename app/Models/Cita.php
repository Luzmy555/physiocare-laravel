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
        'especialidad_id',
        'fecha',
        'hora',
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

    // Relación con especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }
}
