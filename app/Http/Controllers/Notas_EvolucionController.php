<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Nota_Evolucion;
use Illuminate\Http\Request;

class Notas_EvolucionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Mostrar todas las notas de evolución.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notasEvolucion = Nota_Evolucion::paginate(10); // Cambia 10 por el número de notas que deseas mostrar por página
        return view('notas_evolucion.index', compact('notasEvolucion'));
    }

    /**
     * Mostrar el formulario para crear una nueva nota de evolución.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('notas_evolucion.create');
    }

    /**
     * Guardar una nueva nota de evolución.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($cita_id)
    {
        // Encuentra la cita por ID
        $cita = Citas::findOrFail($cita_id);

        // Obtén las notas de evolución asociadas a la cita
        $notasEvolucion = Nota_Evolucion::where('cita_id', $cita_id)->get();

        // Retorna las notas de evolución como JSON
        return response()->json($notasEvolucion);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'cita_id' => 'required|exists:citas,id',
            'descripcion' => 'required|string',
            'fecha_nota' => 'required|date',
            'observaciones_evolucion' => 'nullable|string',
            'estado_nota' => 'required|string',
        ]);

        // Crear una nueva nota de evolución
        Nota_Evolucion::create($request->all());

        // Redirigir a la vista de edición de citas en modo "editar"
        return redirect()->route('citas.edit', ['cita' => $request->cita_id, 'modo' => 'editar'])->with(['message' => 'Nota de evolución creada con éxito']);
    }

    /**
     * Mostrar el formulario para editar una nota de evolución existente.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $notaEvolucion = Nota_Evolucion::findOrFail($id);
        return view('notas_evolucion.edit', compact('notaEvolucion'));
    }

    /**
     * Actualizar una nota de evolución existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'descripcion' => 'required|string',
            'observaciones' => 'nullable|string',
            'estado_nota' => 'required|string',
        ]);

        $notaEvolucion = Nota_Evolucion::findOrFail($id);

        // Actualizar los datos de la nota de evolución
        $notaEvolucion->update($request->all());

       return redirect()->route('citas.edit', ['cita' => $notaEvolucion->cita_id, 'modo' => 'editar'])->with(['message' => 'Nota de evolución actualizada con éxito']);
    }

    /**
     * Eliminar una nota de evolución de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
  }
  /**
 * Cambiar el estado de una nota de evolución entre 'Activo' e 'Inactivo'.
 *
 * @param int $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function toggleStatus($id)
{
    $notaEvolucion = Nota_Evolucion::findOrFail($id);

    // Cambiar el estado de la nota de evolución
    $notaEvolucion->estado_nota = $notaEvolucion->estado_nota === 'Activo' ? 'Inactivo' : 'Activo';
    $notaEvolucion->save();

    return redirect()->route('citas.edit', ['cita' => $notaEvolucion->cita_id, 'modo' => 'editar'])
        ->with(['message' => 'Estado de la nota de evolución actualizado con éxito']);
}
}
