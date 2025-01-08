<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaClinica extends Model
{
    use HasFactory;
    protected $table = 'fichas_clinicas';
    protected $fillable = [
        'paciente_id',
        'medicamentos',
        'alergias',
        'embarazo',
        'tiempo_gestacion',
        'enfermedades_sistemicas',
        'hipertension',
        'diabetes',
        'otros',
        'reaccion_alergica_medicamento',
        'reaccion_alergica_anestesia',
        'observaciones',
    ];

    private $encryption_key = '6e8addd239fd21fb98f7351077a22731284852218b788dd780235193b35152bd';

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    // Mutadores y Accesores para encriptar y desencriptar los campos

    public function setMedicamentosAttribute($value)
    {
        $this->attributes['medicamentos'] = $this->encrypt($value);
    }

    public function getMedicamentosAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setAlergiasAttribute($value)
    {
        $this->attributes['alergias'] = $this->encrypt($value);
    }

    public function getAlergiasAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setEmbarazoAttribute($value)
    {
        $this->attributes['embarazo'] = $this->encrypt($value);
    }

    public function getEmbarazoAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setTiempoGestacionAttribute($value)
    {
        $this->attributes['tiempo_gestacion'] = $this->encrypt($value);
    }

    public function getTiempoGestacionAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setEnfermedadesSistemicasAttribute($value)
    {
        $this->attributes['enfermedades_sistemicas'] = $this->encrypt($value);
    }

    public function getEnfermedadesSistemicasAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setHipertensionAttribute($value)
    {
        $this->attributes['hipertension'] = $this->encrypt($value);
    }

    public function getHipertensionAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setDiabetesAttribute($value)
    {
        $this->attributes['diabetes'] = $this->encrypt($value);
    }

    public function getDiabetesAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setOtrosAttribute($value)
    {
        $this->attributes['otros'] = $this->encrypt($value);
    }

    public function getOtrosAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setReaccionAlergicaMedicamentoAttribute($value)
    {
        $this->attributes['reaccion_alergica_medicamento'] = $this->encrypt($value);
    }

    public function getReaccionAlergicaMedicamentoAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setReaccionAlergicaAnestesiaAttribute($value)
    {
        $this->attributes['reaccion_alergica_anestesia'] = $this->encrypt($value);
    }

    public function getReaccionAlergicaAnestesiaAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = $this->encrypt($value);
    }

    public function getObservacionesAttribute($value)
    {
        return $this->decrypt($value);
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
