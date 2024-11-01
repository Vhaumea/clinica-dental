<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

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
        ]);

        // Asignar nuevos valores al objeto del usuario
        $user->phone = $request->input('phone');
        $user->direccion = $request->input('direccion');

        // Subir la imagen
		$image_path = $request->file('image');
		if($image_path){
			// Poner nombre unico
			$image_path_name = time().$image_path->getClientOriginalName();
			
			// Guardar en la carpeta storage (storage/app/users)
			Storage::disk('users')->put($image_path_name, File::get($image_path));
			
			// Seteo el nombre de la imagen en el objeto
			$user->image = $image_path_name;
		}
		
        // Guardar los cambios en la base de datos
        $user->update();
        return redirect()->route('config') 
            ->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($filename){
		$file = Storage::disk('users')->get($filename);
		return new Response($file, 200);
	}
}
