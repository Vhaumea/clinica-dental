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
        'pieza',
        'tratamiento',
        'tratamiento_estado',
        'observaciones',
        'precio',
    ];


    private $encryption_key = '6e8addd239fd21fb98f7351077a22731284852218b788dd780235193b35152bd'; 

    public function presupuestos()
    {
        return $this->belongsTo(Presupuesto::class);
    }

     // Mutador para encriptar el tratamiento
     public function setTratamientoAttribute($value)
     {
         $this->attributes['tratamiento'] = $this->encrypt($value);
     }
 
     // Accesor para desencriptar el tratamiento
     public function getTratamientoAttribute($value)
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
