<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'rut',
        'name',
        'apellido_m',
        'apellido_p',
        'fecha_nacimiento',
        'sexo',
        'email',
        'region',
        'comuna',
        'phone',
        'direccion',
        'password',
        'image',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //muestra en adminlte la vista de la imagen del usuario
    public function adminlte_image()
    {
        return route('user.avatar', ['filename' => $this->image]);
    }

    public function adminlte_desc()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        return $user->role;
    }

    public function adminlte_profile_url()
    {
        return route('config');
    }
    /**
     * Check if the user has the role of Admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    //relacion con horarios laborales
    public function horarios_laborales()
    {
        return $this->hasMany(Horarios_laborales::class, 'user_id');
    }
}
