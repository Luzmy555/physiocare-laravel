<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'rol_id'
    ];

    protected $hidden = ['password'];

    // Un usuario pertenece a un rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Si este usuario es fisioterapeuta
    public function fisioterapeuta()
    {
        return $this->hasOne(Fisioterapeuta::class);
    }
}
