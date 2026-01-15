<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Una especialidad tiene muchos fisioterapeutas
    public function fisioterapeutas()
    {
        return $this->hasMany(Fisioterapeuta::class);
    }
}
