<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieza_dental extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla.
    protected $table = 'pieza_dental';

    // Definir los campos que son asignables.
    protected $fillable = [
        'diente',
        'nombre',
        'observacion',
    ];
}
