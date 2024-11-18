<?php

namespace App\Http\Controllers;

use App\Models\DetallePresupuesto;
use Illuminate\Http\Request;

class DetallePresupuestoController extends Controller
{

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'pieza_id.*' => 'required|string|max:255',
            'tratamiento.*' => 'required|string|max:255',
            'observaciones.*' => 'nullable|string|max:255',
            'precio.*' => 'required|numeric|min:0',
        ]);

        // Guardar los detalles en la base de datos
        foreach ($validatedData['pieza_id'] as $index => $pieza) {
            DetallePresupuesto::create([
                'pieza_id' => $pieza,
                'tratamiento' => $validatedData['tratamiento'][$index],
                'observaciones' => $validatedData['observaciones'][$index] ?? null,
                'precio' => $validatedData['precio'][$index],
            ]);
        }

        // Retornar una respuesta JSON con los datos guardados
        return response()->json(['success' => true, 'message' => 'Detalles guardados con éxito']);
    }

    public function index()
    {
        // Obtener todos los detalles de presupuesto para mostrarlos en la vista
        $detalles = DetallePresupuesto::all();
        return response()->json($detalles);
    }
}
