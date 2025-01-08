<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($presupuesto_id)
    {
        $presupuesto = Presupuesto::with('paciente', 'detalles')->findOrFail($presupuesto_id);
        $abonos = Abono::where('presupuesto_id', $presupuesto_id)->get();
        $totalAbonos = $abonos->sum('monto_abono');
        $saldoPendiente = $presupuesto->total_final - $totalAbonos;
    
        return view('abonos.create', compact('presupuesto', 'abonos', 'totalAbonos', 'saldoPendiente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'presupuesto_id' => 'required|exists:presupuesto,id',
            'monto_abono' => 'required|numeric|min:0',
            'fecha_abono' => 'required|date',
            'metodo_pago' => 'required|in:Efectivo,Tarjeta Crédito,Tarjeta Débito,Transferencia',
            'notas' => 'nullable|string|max:255',
        ]);

        $abono = Abono::create($request->all());
        $presupuesto = Presupuesto::findOrFail($request->presupuesto_id);
        $presupuesto->calcularSaldoPendiente();

        return redirect()->route('presupuestos.edit', $presupuesto->id)->with('message', 'Abono creado correctamente.');
    }

    public function edit($id)
    {
        $abono = Abono::findOrFail($id);
        return view('abonos.edit', compact('abono'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'monto_abono' => 'required|numeric|min:0',
            'fecha_abono' => 'required|date',
            'metodo_pago' => 'required|in:Efectivo,Tarjeta Crédito,Tarjeta Débito,Transferencia',
            'notas' => 'nullable|string|max:255',
        ]);

        $abono = Abono::findOrFail($id);
        $abono->update($request->all());

        return redirect()->route('abonos.create', $abono->presupuesto_id)->with('message', 'Abono actualizado con éxito.');
    }
}