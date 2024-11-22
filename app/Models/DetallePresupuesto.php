<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePresupuesto extends Model
{
    use HasFactory;

    protected $table = 'detalle_presupuesto'; // Asegúrate de especificar el nombre correcto

    protected $fillable = [
        'presupuesto_id',
        'pieza_id',
        'tratamiento',
        'observaciones',
        'precio',
    ];



    public function presupuestos()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
