<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function crear()
    {
        return view('pacientes.crear'); // Vista para crear paciente
    }

    // Método para crear un nuevo paciente
    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [

            'rut' => 'required|string|max:255|unique:pacientes',
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:200',
            'apellido_m' => 'nullable|string|max:200',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'email' => 'required|string|email|max:255|unique:pacientes',
            'birth' => 'required|date',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string',
        ]);

        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el nuevo Paciente
        Pacientes::create([
            'rut' => $request->rut,
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'birth' => $request->birth,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('pacientes.index')->with(['message' => 'Paciente creado con exito']);
    }
    public function index()
    {
        // Obtener todos los pacientes
        $pacientes = Pacientes::all();

        // Retornar la vista con los pacientes
        return view('pacientes\index', compact('pacientes'));
    }


    public function edit($id, Request $request)
    {
        // Obtener el paciente por ID
        $paciente = Pacientes::find($id);
        // Determinar el modo (ver o editar)
        $modo = $request->query('modo', 'ver'); // Por defecto es 'ver'
        // Retornar la vista con los datos del usuario
        return view('pacientes.edit', compact('paciente', 'modo'));
    }

    public function update(Request $request, $id)
    {
        // Validación y actualización del paciente
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:pacientes',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string',
        ]);
        // Obtener el usuario por ID
        $pacientes = pacientes::find($id);

        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Asignar nuevos valores al objeto del paciente

        $pacientes->email = $request->input('email');
        $pacientes->telefono = $request->input('telefono');
        $pacientes->direccion = $request->input('direccion');

        // Guardar los cambios en la base de datos
        $pacientes->update();
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente.');
    }
}
