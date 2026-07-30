<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialArchivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'historial_clinico_id',
        'nombre_original',
        'path',
        'mime_type',
        'tamano',
        'subido_por',
    ];

    public function historial()
    {
        return $this->belongsTo(HistorialClinico::class, 'historial_clinico_id');
    }
}
