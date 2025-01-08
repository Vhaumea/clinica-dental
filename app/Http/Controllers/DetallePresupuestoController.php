<?php

namespace App\Http\Controllers;

use App\Models\DetallePresupuesto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class DetallePresupuestoController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
     }
     
    /**
     * Almacena un nuevo detalle de presupuesto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

     

    public function create()
    {

        // Retornar la vista con los datos del presupuesto
        return view('presupuestos.create', compact('detalles', 'presupuestos'));
    }

    public function store(Request $request)
    {
        // Valida los datos del detalle del presupuesto
        $request->validate([
            'presupuesto_id' => 'required|exists:presupuesto,id',
            'pieza' => 'required|string|max:10',
            'tratamiento' => 'required|string|max:1000',
            'tratamiento_estado' => 'required|string|in:Pendiente,En proceso,Completado',
            'observaciones' => 'required|string|max:1000',
            'precio' => 'required|numeric',
        ]);

        // Crea el nuevo detalle de presupuesto
        $detalle = DetallePresupuesto::create($request->all());

        // Actualizar el total del presupuesto asociado
        $presupuesto = Presupuesto::find($detalle->presupuesto_id);

        // Recalcular el total final
        $presupuesto->subtotal += $detalle->precio;
        $presupuesto->calcularTotalFinal();
        $presupuesto->calcularSaldoPendiente();

        return redirect()->route('presupuestos.edit', $presupuesto->id)->with('message', 'Detalle agregado correctamente.');
    }

    public function edit($id)
    {
        $detalle = DetallePresupuesto::findOrFail($id);
        return view('detalles.edit', compact('detalle'));
    }

    public function update(Request $request, $id)
    {
        // Valida los datos del detalle del presupuesto
        $request->validate([
            'pieza' => 'required|string|max:10',
            'tratamiento' => 'required|string|max:1000',
            'tratamiento_estado' => 'required|string|in:Pendiente,En proceso,Completado',
            'observaciones' => 'required|string|max:1000',
            'precio' => 'required|numeric',
        ]);

        // Actualiza el detalle del presupuesto
        $detalle = DetallePresupuesto::findOrFail($id);
        $detalle->update($request->all());

        // Actualizar el total del presupuesto asociado
        $presupuesto = Presupuesto::find($detalle->presupuesto_id);

        // Recalcular el total final
        $subtotal = DetallePresupuesto::where('presupuesto_id', $detalle->presupuesto_id)->sum('precio');

        // Actualizar el campo subtotal en el presupuesto
        $presupuesto->subtotal = $subtotal;
        $presupuesto->save();

        return redirect()->route('presupuestos.edit', ['presupuesto' => $detalle->presupuesto_id])
            ->with('message', 'Detalle actualizado con éxito.');
    }
}
