<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePresupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'presupuesto_id',
        'pieza_dental_id',
        'tratamiento',
        'tratamiento_estado',
        'precio',
        'observaciones',
    ];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class, 'presupuesto_id');
    }
}
