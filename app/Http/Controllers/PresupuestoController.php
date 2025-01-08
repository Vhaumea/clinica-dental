<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Abono;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

use App\Models\DetallePresupuesto;

class PresupuestoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Muestra la vista para crear presupuestos.
     *
     * @return \Illuminate\View\View
     * 
     */
    public function show($id)
    {
        $presupuestos = Presupuesto::orderBy('created_at', 'desc')->get();

        return view('presupuestos.index', compact('presupuestos'));
    }

    public function index($pacienteId)
    {
        $paciente = Pacientes::findOrFail($pacienteId);
        $presupuestos = Presupuesto::with('paciente')->where('paciente_id', $pacienteId)->get();

        return view('presupuestos.index', compact('paciente', 'presupuestos'));
    }


    public function create(Request $request)
    {
        $presupuesto_id = $request->query('presupuesto_id');
        $detalles = DetallePresupuesto::where('presupuesto_id', $presupuesto_id)->get();
        $pacientes = Pacientes::all();
        $presupuestos = Presupuesto::all();
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
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'nombre_paciente' => 'required|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0|max:100',
            'fecha' => 'required|date',
        ]);

        $presupuesto = Presupuesto::create($request->all());
        $presupuesto->calcularTotalFinal();
        $presupuesto->calcularSaldoPendiente();

        return redirect()->route('presupuestos.create', ['presupuesto_id' => $presupuesto->id])->with('message', 'Presupuesto creado con éxito. Crea detalles para el presupuesto.');
    }

    public function edit($id, Request $request)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $detalles = DetallePresupuesto::where('presupuesto_id', $id)->get();
        $pacientes = Pacientes::all();
        $abonos = Abono::where('presupuesto_id', $id)->get();
        $modo = $request->query('modo', 'ver');

        return view('presupuestos.edit', compact('presupuesto', 'detalles', 'pacientes', 'abonos', 'modo'));
    }

    public function update(Request $request, $id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->update($request->all());
        $presupuesto->calcularTotalFinal();
        $presupuesto->calcularSaldoPendiente();

        return redirect()->route('presupuestos.edit', $presupuesto->id)->with('message', 'Presupuesto actualizado correctamente.');
    }
}
