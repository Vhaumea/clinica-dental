<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota_Evolucion extends Model
{
    use HasFactory;

    // Especifica la tabla asociada (opcional si sigue la convención de nombres)
    protected $table = 'notas_evolucion';

    // Especifica los campos que se pueden asignar masivamente
    protected $fillable = [
        'cita_id',
        'descripcion',
        'fecha_nota',
        'observaciones_evolucion',
        'estado_nota',
    ];

    private $encryption_key = '6e8addd239fd21fb98f7351077a22731284852218b788dd780235193b35152bd'; 

    // Relación con la tabla Citas
    public function cita()
    {
        return $this->belongsTo(Citas::class);
    }

     // Mutador para encriptar la descripcion
     public function setDescripcionAttribute($value)
     {
         $this->attributes['descripcion'] = $this->encrypt($value);
     }
 
     // Accesor para desencriptar la descripcion
     public function getDescripcionAttribute($value)
     {
         return $this->decrypt($value);
     }
 
     // Mutador para encriptar las observaciones
     public function setObservacionesAttribute($value)
     {
         $this->attributes['observaciones'] = $this->encrypt($value);
     }
 
     // Accesor para desencriptar las observaciones
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
