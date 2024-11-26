<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function crear()
    {
        return view('users.create'); 
    }


    // Método para crear un nuevo usuario
    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|max:100',
            'rut' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:200',
            'apellido_m' => 'nullable|string|max:200',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'direccion' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el nuevo usuario
        User::create([
            'role' => $request->role,
            'rut' => $request->rut,
            'name' => $request->name,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'phone' => $request->phone,
            'direccion' => $request->direccion,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('users.listar') // Cambia esto a tu ruta deseada
            ->with(['message' => 'Usuario creado correctamente']);
    }

    //lista todos los usuarios
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();

        // Retornar la vista con los usuarios
        return view('users\listar', compact('usuarios'));
    }

    public function configuracion($id, Request $request)
    {
        // Obtener el usuario por ID
        $usuario = User::find($id);
        // Determinar el modo (ver o editar)
        $modo = $request->query('modo', 'ver'); // Por defecto es 'ver'
        // Retornar la vista con los datos del usuario
        return view('users.configuracion', compact('usuario', 'modo'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'direccion' => 'required|string',
        ]);

        // Obtener el usuario por ID
        $usuario = User::find($id);

        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
        }

        // Actualizar los datos del usuario
        $usuario->email = $request->input('email');
        $usuario->phone = $request->input('phone');
        $usuario->direccion = $request->input('direccion');

        // Guardar los cambios
        $usuario->update();
        return redirect()->route('users.configuracion', ['id' => $id])
            ->with('message', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        // Obtener el usuario por ID
        $usuario = User::find($id);

        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
        }

        // Eliminar el usuario
        $usuario->delete();

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.listar')->with('message', 'Usuario eliminado correctamente.');
    }
}
