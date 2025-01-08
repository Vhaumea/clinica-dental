<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use App\Models\FichaClinica;

use App\Models\Citas;
use App\Models\Nota_Evolucion;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function crear()
    {
        return view('pacientes.crear'); 
    }

    // Método para crear un nuevo paciente
    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [

            'rut' => 'required|string|max:255|unique:pacientes',
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:200',
            'apellido_m' => 'required|string|max:200',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'email' => 'nullable|string|email|max:255|unique:pacientes',
            'birth' => 'required|date',
            'telefono' => 'required|string|max:15',
            'region' => 'required|string|max:100', 
            'comuna' => 'required|string|max:100', 
            'direccion' => 'required|string',
            'estado' => 'required|string',
        ]);

        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el paciente
        $paciente = Pacientes::create($request->all());

        // Redirigir a la vista de creación de la ficha clínica
        return redirect()->route('fichas_clinicas.create', ['paciente_id' => $paciente->id])->with(['message' => 'Paciente creado con éxito. Crear la ficha clínica.']);
    }

    public function index()
    {
        // Obtener todos los pacientes
        $pacientes = Pacientes::all();

        // Retornar la vista con los pacientes
        return view('pacientes.index', compact('pacientes'));
    }


    public function edit($id, Request $request)
    {
        $paciente = Pacientes::findOrFail($id);
        $fichaClinica = FichaClinica::where('paciente_id', $id)->first();
        $citas = Citas::where('paciente_id', $id)->get();
        $notaEvolucion = Nota_Evolucion::where('cita_id', $citas->first()->id ?? null)->first();
        $modo = $request->query('modo', 'ver'); // Por defecto es 'ver'
        return view('pacientes.edit', compact('paciente', 'fichaClinica', 'citas', 'notaEvolucion', 'modo'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable|email|max:255',
            'telefono' => 'required|string|max:255',
            'region' => 'required|string|max:100', 
            'comuna' => 'required|string|max:100', 
            'direccion' => 'required|string|max:255',
            'estado' => 'required|string',
        ]);

        $paciente = Pacientes::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.edit', ['id' => $id])
            ->with('message', 'Paciente actualizado correctamente');
    }

   
}
