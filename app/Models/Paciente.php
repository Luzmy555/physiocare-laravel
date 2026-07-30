<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'correo',
        'fecha_nacimiento',
        'direccion',
        'sexo'
    ];

    // Un paciente tiene muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    // Un paciente tiene muchos historiales clínicos
    public function historiales()
    {
        return $this->hasMany(HistorialClinico::class);
    }
}
