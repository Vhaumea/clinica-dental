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
        'fecha',
        'estado',
    ];

    // Definir la relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }


    public function detalles()
    {
        return $this->hasMany(DetallePresupuesto::class);
    }

    public function abonos()
    {
        return $this->hasMany(Abono::class);
    }

    public function calcularTotalFinal()
    {
        $subtotal = $this->subtotal;
        $descuento = $this->descuento ?? 0;
        $this->total_final = $subtotal - ($subtotal * ($descuento / 100));
        $this->save();
    }

    public function calcularSaldoPendiente()
    {
        $totalAbonos = $this->abonos->sum('monto_abono');
        $this->saldo_pendiente = $this->total_final - $totalAbonos;
        $this->save();
    }
}
