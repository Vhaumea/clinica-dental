<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{

     use HasFactory;

    protected $fillable = [
        'presupuesto_id',
        'monto_abono',
        'fecha_abono',
        'metodo_pago',
        'notas',
    ];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
