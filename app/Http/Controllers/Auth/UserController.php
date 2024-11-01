<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config()
    {
        return view('user.config');
    }

    public function update(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Validar los datos de entrada
        $request->validate([
            'phone' => 'required|string|max:15', // Ajusta el tamaño según tus necesidades
            'direccion' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Asignar nuevos valores al objeto del usuario
        $user->phone = $request->input('phone');
        $user->direccion = $request->input('direccion');

        // Manejo de la imagen (si se sube una nueva)
        if ($request->hasFile('image')) {
            // Guardar la imagen y obtener la ruta
            $path = $request->file('image')->store('images', 'public');
            $user->image = $path; // Asigna la ruta a la propiedad image
        }

        // Guardar los cambios en la base de datos
        $user->update();

        return redirect()->route('profile') // Cambia esto a tu ruta deseada
            ->with(['message' => 'Usuario actualizado correctamente']);
    }
}
