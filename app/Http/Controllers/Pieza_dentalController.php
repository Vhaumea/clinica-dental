<?php

namespace App\Http\Controllers;

use App\Models\Pieza_dental;  // Importar el modelo
use Illuminate\Http\Request;

class Pieza_dentalController extends Controller
{
    /**
     * Mostrar todas las piezas dentales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $piezaDentales = Pieza_dental::all();
        return view('pieza_dental.index', compact('piezaDentales'));
    }
    
    /**
     * Mostrar el formulario para crear una nueva pieza dental.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pieza_dental.create');  // Retorna la vista del formulario de creación
    }

    /**
     * Guardar una nueva pieza dental.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'diente' => 'required|string|max:10',
            'nombre' => 'required|string|max:50',
            'observacion' => 'nullable|string|max:255',
        ]);
    
        Pieza_dental::create($request->all());
    
        return redirect()->route('pieza_dental.index')->with('success', 'Pieza dental creada correctamente');
    }
    

    /**
     * Mostrar el formulario para editar una pieza dental.
     *
     * @param \App\Models\Pieza_dental $piezaDental
     * @return \Illuminate\View\View
     */
    public function edit(Pieza_dental $piezaDental)
    {
        return view('pieza_dental.edit', compact('piezaDental'));  // Retorna la vista de edición con la pieza dental a editar
    }

    /**
     * Actualizar una pieza dental existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pieza_dental $piezaDental
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pieza_dental $piezaDental)
    {
        // Validar los datos del formulario
        $request->validate([
            'diente' => 'required|string|max:10',
            'nombre' => 'required|string',
            'observacion' => 'nullable|string|max:255',
        ]);

        // Actualizar los datos de la pieza dental
        $piezaDental->update($request->all());

        // Redirigir a la lista de piezas dentales con un mensaje de éxito
        return redirect()->route('pieza_dental.index')->with('success', 'Pieza dental actualizada correctamente');
    }

    /**
     * Eliminar una pieza dental de la base de datos.
     *
     * @param \App\Models\Pieza_dental $piezaDental
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pieza_dental $piezaDental)
    {
        // Eliminar la pieza dental
        $piezaDental->delete();

        // Redirigir a la lista de piezas dentales con un mensaje de éxito
        return redirect()->route('pieza_dental.index')->with('success', 'Pieza dental eliminada correctamente');
    }
}
 
