<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CitaPublica extends Model
{
    use HasFactory;

    protected $table = 'citas_publicas';

    protected $fillable = [
        'cedula',
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'especialidad_id',
        'fisioterapeuta_id',
        'fecha_cita',
        'hora_cita',
        'motivo',
        'estado',
        'notas_medico',
    ];

    protected $casts = [
        'fecha_cita' => 'date',
    ];

    // Relación con especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    // Relación con fisioterapeuta
    public function fisioterapeuta()
    {
        return $this->belongsTo(Fisioterapeuta::class);
    }
}
