<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Presupuesto; 
use Illuminate\Http\Request;

use App\Models\DetallePresupuesto;

class PresupuestoController extends Controller
{
    /**
     * Muestra la vista para crear presupuestos.
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Obtiene todos los presupuestos paginados de a 3 en orden descendente
        $presupuestos = Presupuesto::orderBy('created_at', 'desc')->paginate(8);
        
        return view('presupuestos.index', compact('presupuestos')); 
    }

    public function index()
    {
        // Obtener todos los presupuestos
        $presupuestos = Presupuesto::with('detalles')->get();

        // Calcular el total para cada presupuesto
        foreach ($presupuestos as $presupuesto) {
            $presupuesto->total_final = $presupuesto->detalles->sum('precio');
            $presupuesto->save(); // Guarda el total en la base de datos si es necesario
        }

        return view('presupuestos.index', compact('presupuestos'));
    }
    public function create()
    {

        $detalles = DetallePresupuesto::orderBy('created_at', 'desc')->get();

        // Obtener todos los pacientes
        $pacientes = Pacientes::all();
        // Obtiene todos los presupuestos paginados de a 3 en orden descendente
        $presupuestos = Presupuesto::orderBy('created_at', 'desc')->get();

        // Get the last created Presupuesto
        $lastPresupuesto = Presupuesto::latest()->first();

        return view('presupuestos.create', compact('pacientes', 'presupuestos', 'lastPresupuesto', 'detalles'));
    }

    /**
     * Almacena un nuevo presupuesto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida los datos del presupuesto
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id', // Asegúrate de que el paciente exista
            'nombre_paciente' => 'required|string|max:255',
        ]);

        // Crea el nuevo presupuesto
        Presupuesto::create($request->all());

        // Redirige a la vista de creación con un mensaje de éxito
        return redirect()->route('presupuestos.create')->with('success', 'Presupuesto creado con éxito.');
    }
}
