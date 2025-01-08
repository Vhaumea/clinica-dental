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
        'medio',
        'estado',
        'observaciones',
    ];

    private $encryption_key = '6e8addd239fd21fb98f7351077a22731284852218b788dd780235193b35152bd'; 

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

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['motivo', 'origen', 'observaciones'])) {
            $value = $this->encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, ['motivo', 'origen', 'observaciones'])) {
            $value = $this->decrypt($value);
        }
        return $value;
    }

    private function encrypt($value)
    {
        return openssl_encrypt($value, 'aes-256-cbc', $this->encryption_key, 0, $this->getIv());
    }

    private function decrypt($value)
    {
        return openssl_decrypt($value, 'aes-256-cbc', $this->encryption_key, 0, $this->getIv());
    }

    private function getIv()
    {
        return substr(hash('sha256', $this->encryption_key), 0, 16);
    }
}