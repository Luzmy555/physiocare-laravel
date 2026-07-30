<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_publica_id',
        'fisioterapeuta_id',
        'medicamentos',
        'indicaciones',
    ];

    public function citaPublica()
    {
        return $this->belongsTo(CitaPublica::class);
    }

    public function fisioterapeuta()
    {
        return $this->belongsTo(Fisioterapeuta::class);
    }
}
