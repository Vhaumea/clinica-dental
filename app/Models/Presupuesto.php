<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    // Especificar la tabla si no sigue la convención de nombres
    protected $table = 'presupuesto';

    // Definir los atributos que son asignables en masa
    protected $fillable = [
        'paciente_id',
        'subtotal',
        'descuento',
        'total_final',
        'saldo_pendiente',
        'estado',
    ];

    // Definir la relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }
    
    public function detalles()
    {
        return $this->hasMany(DetallePresupuesto::class, 'presupuesto_id');
    }
    
}