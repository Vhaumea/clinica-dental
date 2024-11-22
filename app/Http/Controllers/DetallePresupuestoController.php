<?php

namespace App\Http\Controllers;

use App\Models\DetallePresupuesto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class DetallePresupuestoController extends Controller
{
    /**
     * Almacena un nuevo detalle de presupuesto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */



    public function create()
    {
       
        // Retornar la vista con los datos del presupuesto
        return view('presupuestos.create', compact('detalles','presupuestos'));
    }

    public function store(Request $request)
    {
        // Valida los datos del detalle del presupuesto
        $request->validate([
            'presupuesto_id' => 'required|exists:presupuesto,id',
            'pieza' => 'required|string|max:10',
            'tratamiento' => 'required|string|max:1000',
            'observaciones' => 'required|string|max:1000',
            'precio' => 'required|numeric',
        ]);

        // Crea el nuevo detalle de presupuesto
        $detalle = DetallePresupuesto::create($request->all());

        // Actualizar el total del presupuesto asociado
        $presupuesto = Presupuesto::find($detalle->presupuesto_id);

        // Recalcular el total final
        $subtotal = DetallePresupuesto::where('presupuesto_id', $detalle->presupuesto_id)->sum('precio');

        // Actualizar el campo subtotal en el presupuesto
        $presupuesto->subtotal = $subtotal;
        $presupuesto->save();

        // Redirige a la vista de creación con un mensaje de éxito
        return redirect()->route('presupuestos.create')->with('success', 'Detalle agregado con éxito.');
    }
}
