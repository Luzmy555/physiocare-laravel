<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialClinico extends Model
{
    use HasFactory;

    protected $table = 'historiales_clinicos';

    protected $fillable = [
        'paciente_id',
        'fisioterapeuta_id',
        'observaciones',
        'diagnostico',
        'tratamiento'
    ];

    // Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Fisioterapeuta
    public function fisioterapeuta()
    {
        return $this->belongsTo(Fisioterapeuta::class);
    }

    // Archivos adjuntos (notas, análisis, documentos)
    public function archivos()
    {
        return $this->hasMany(HistorialArchivo::class);
    }
}
