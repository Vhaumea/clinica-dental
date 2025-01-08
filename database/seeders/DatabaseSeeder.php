<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario
        User::create([
            'role' => 'Admin',
            'rut' => '1234567-9',
            'name' => 'Jeniffer',
            'apellido_p' => 'Espinoza',
            'apellido_m' => 'E.',
            'fecha_nacimiento' => '1990-01-01',
            'sexo' => 'Femenino',
            'email' => 'jeniffer.espinozap@example.com',
            'phone' => '123456789',
            'direccion' => '123 Calle Falsa',
            'password' => Hash::make('12345678'),
            'estado' => 'Activo',
            'region' => 'Metropolitana',
            'comuna' => 'Santiago',
        ]);
    }
}
