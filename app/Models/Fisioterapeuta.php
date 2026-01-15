<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fisioterapeuta extends Model
{
    use HasFactory;

    protected $table = 'fisioterapeutas';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'correo',
        'especialidad_id',
        'numero_colegiado',
        'password',
        'horario_inicio',
        'horario_fin',
    ];

    protected $hidden = ['password'];


    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    // Un fisioterapeuta tiene muchas citas públicas
    public function citasPublicas()
    {
        return $this->hasMany(CitaPublica::class);
    }

    // Un fisioterapeuta tiene muchas citas (antiguo sistema)
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
    // Un fisioterapeuta tiene muchos horarios
public function horarios()
{
    return $this->hasMany(Horario::class);
}

}
