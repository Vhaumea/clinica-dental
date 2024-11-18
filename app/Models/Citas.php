<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'user_id',
        'presupuesto_id',
        'fecha',
        'hora',
        'motivo',
        'origen',
        'estado',
        'observaciones',
    ];

    // Relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    // Relación con el modelo User (doctor/secretaria)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Presupuesto
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
