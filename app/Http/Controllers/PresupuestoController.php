<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Presupuesto; // Importar el modelo
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    /**
     * Mostrar todos los presupuestos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $presupuestos = Presupuesto::paginate(10); // Obtener todos los presupuestos con paginación
        return view('presupuestos.index', compact('presupuestos')); // Retorna la vista con los presupuestos
    }

    /**
     * Mostrar el formulario para crear un nuevo presupuesto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtener todos los pacientes
        $pacientes = Pacientes::all();
        return view('presupuestos.create', compact('pacientes')); // Retorna la vista del formulario de creación

    }

    /**
     * Almacenar un nuevo presupuesto.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'subtotal' => 'required|integer',
            'descuento' => 'required|integer',
            'total_final' => 'required|integer',
            'saldo_pendiente' => 'required|decimal:0,2',
            'estado' => 'required|in:pendiente,en proceso,rechazado',
        ]);

        Presupuesto::create($request->all()); // Crear el nuevo presupuesto

        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto creado correctamente'); // Redirigir a la lista de presupuestos
    }

    /**
     * Mostrar el formulario para editar un presupuesto existente.
     *
     * @param \App\Models\Presupuesto $presupuesto
     * @return \Illuminate\View\View
     */
    public function edit(Presupuesto $presupuesto)
    {
        return view('presupuestos.edit', compact('presupuesto')); // Retorna la vista de edición con el presupuesto a editar
    }

    /**
     * Actualizar un presupuesto existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presupuesto $presupuesto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Presupuesto $presupuesto)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'subtotal' => 'required|integer',
            'descuento' => 'required|integer',
            'total_final' => 'required|integer',
            'saldo_pendiente' => 'required|decimal:0,2',
            'estado' => 'required|in:pendiente,en proceso,rechazado',
        ]);

        $presupuesto->update($request->all()); // Actualizar los datos del presupuesto

        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto actualizado correctamente'); // Redirigir a la lista de presupuestos
    }

    /**
     * Eliminar un presupuesto de la base de datos.
     *
     * @param \App\Models\Presupuesto $presupuesto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Presupuesto $presupuesto)
    {
        $presupuesto->delete(); // Eliminar el presupuesto

        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto eliminado correctamente'); // Redirigir a la lista de presupuestos
    }

    public function getPresupuestosPendientes($pacienteId)
    {
        $presupuestos = Presupuesto::where('paciente_id', $pacienteId)
            ->where('estado', 'pendiente')
            ->get(['id', 'detalles', 'created_at']);

        return response()->json($presupuestos);
    }
}
