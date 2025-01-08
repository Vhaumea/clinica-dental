<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'apellido_m' => 'required|string|max:200',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'region' => 'required|string|max:100', 
            'comuna' => 'required|string|max:100', 
            'direccion' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'estado' => 'required|string',
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
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'phone' => $request->phone,
            'region' => $request->direccion,
            'comuna' => $request->comuna,
            'direccion' => $request->direccion,
            'password' => Hash::make($request->password),
            'estado' => $request->estado,
        ]);
        return redirect()->route('users.index') // Cambia esto a tu ruta deseada
            ->with(['message' => 'Usuario creado correctamente']);
    }

    //lista todos los usuarios
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();

        // Retornar la vista con los usuarios
        return view('users/index', compact('usuarios'));
    }

    public function edit($id, Request $request)
    {
        $usuario = User::findOrFail($id);
        $modo = $request->query('modo', 'ver');

        // Verificar si el usuario no es Admin y está intentando acceder al modo de edición
        if (Auth::user()->role !== 'Admin' && $modo === 'editar') {
            return redirect()->route('users.edit', ['id' => $id, 'modo' => 'ver']);
        }

        return view('users.edit', compact('usuario', 'modo'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'region' => 'required|string|max:100', 
            'comuna' => 'required|string|max:100',         
            'direccion' => 'required|string',
        ]);

        // Obtener el usuario por ID
        $usuario = User::find($id);

        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('users.index')->with('message', 'Usuario no encontrado.');
        }

        // Actualizar los datos del usuario
        $usuario->email = $request->input('email');
        $usuario->phone = $request->input('phone');
        $usuario->region = $request->input('region');
        $usuario->comuna = $request->input('comuna');
        $usuario->direccion = $request->input('direccion');
        $usuario->estado = $request->input('estado');

        // Guardar los cambios
        $usuario->update();
        return redirect()->route('users.edit', ['id' => $id])
            ->with('message', 'Usuario actualizado correctamente');
    }

    public function toggleStatus($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->estado = $usuario->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $usuario->save();

        return redirect()->route('users.index')->with('message', 'Estado del usuario actualizado correctamente.');
    }
}
