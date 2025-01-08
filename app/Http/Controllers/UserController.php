<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config(Request $request)
    {
        $modo = $request->query('modo', 'ver'); // Obtener el modo de la consulta, por defecto 'ver'
        return view('user.config', compact('modo'));
    }

    public function update(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Validar los datos de entrada
        $request->validate([
            'phone' => 'required|string|max:15', 
            'region' => 'required|string|max:255',
            'comuna' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Asignar nuevos valores al objeto del usuario
        $user->phone = $request->input('phone');
        $user->region = $request->input('region');
        $user->comuna = $request->input('comuna');
        $user->direccion = $request->input('direccion');

        // Subir la imagen
        $image_path = $request->file('image');
        if ($image_path) {
            // Poner nombre unico
            $image_path_name = time().$image_path->getClientOriginalName();
            
            // Guardar en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            
            // Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        // Guardar los cambios en la base de datos
        $user->update();
        return redirect()->route('config', ['modo' => 'ver'])->with('message', 'Configuración actualizada con éxito');
    }

    public function changePassword(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar la contraseña actual
        if (Hash::check($request->input('current_password'), $user->password)) {
            // Actualizar la contraseña
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect()->route('config', ['modo' => 'ver'])->with('message', 'Contraseña actualizada con éxito');
        } else {
            return redirect()->route('config', ['modo' => 'editar'])->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }
    }

    public function getImage($filename)
    {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
}