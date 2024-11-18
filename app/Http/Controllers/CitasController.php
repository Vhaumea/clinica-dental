<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Citas;  // Importar el modelo
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Horarios_laborales;
use App\Models\Presupuesto;

use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    /**
     * Mostrar todas las citas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        // Por esto:
        $citas = Citas::paginate(10); // Cambia 10 por el número de citas que deseas mostrar por página

        return view('citas.index', compact('citas',));
    }


    /**
     * Mostrar el formulario para crear una nueva cita.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtener solo los usuarios con el rol de 'Dentista'
        $dentistas = User::where('role', 'Dentista')->get();

        // Obtener todos los pacientes
        $pacientes = Pacientes::all();

        //Obtener todos los presupuestos
        $presupuestos = Presupuesto::all();
        // Pasar los datos a la vista
        return view('citas.create', compact('pacientes', 'dentistas', 'presupuestos'));
    }

    /**
     * Guardar una nueva cita.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'nullable|string|max:255',
            'origen' => 'required|in:Urgencia,Presupuesto,Consulta',
            'observaciones' => 'nullable|string|max:255',
            'estado' => 'in:Pendiente,Confirmada,Cancelada,Completada',
        ]);

        // Crear una nueva cita

        $cita = Citas::create([
            'paciente_id' => $request->paciente_id,
            'presupuesto_id' => $request->presupuesto_id,
            'fecha' => $request->fecha,
            'user_id' => $request->user_id,
            'hora' => $request->hora,
            'motivo' => $request->motivo,
            'origen' => $request->origen,
            'observaciones' => $request->observaciones,
            'estado' => $request->estado ?: 'Pendiente', // Asigna estado por defecto si no se proporciona
        ]);
        return redirect()->route('citas.index')->with(['message' => 'Cita creada con exito']);
    }

    /**
     * Mostrar el formulario para editar una cita existente.
     *
     * @param \App\Models\Citas $cita
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $cita = Citas::findOrFail($id); //obtener cita por id
        
        $modo = $request->query('modo', 'ver'); // Por defecto es 'ver'
        // Retornar la vista con los datos del usuario
        return view('citas.edit', compact('cita', 'modo'));  // Retorna la vista de edición con la cita a editar
    }

    /**
     * Actualizar una cita existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Citas $cita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Citas $cita)
    {
        // Validar los datos del formulario
        $request->validate([
            'observaciones' => 'nullable|string|max:255',
            'estado' => 'in:Pendiente,Confirmada,Cancelada,Completada',
        ]);

        // Actualizar los datos de la cita
        $cita->update($request->all());

        // Redirigir a la lista de citas con un mensaje de éxito
        return redirect()->route('citas.index')->with(['message' => 'Cita actializada con exito']);
    }

    /**
     * Eliminar una cita de la base de datos.
     *
     * @param \App\Models\Citas $cita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Citas $cita)
    {
        // Eliminar la cita
        $cita->delete();

        // Redirigir a la lista de citas con un mensaje de éxito
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
    }

    public function obtenerPresupuestosPendientes($pacienteId)
    {
        $presupuestos = Presupuesto::where('paciente_id', $pacienteId)
            ->where('estado', 'pendiente')
            ->get(['id', 'detalles', 'created_at']); //falta traer el nombre del tratamiento

        return response()->json($presupuestos);
    }

    public function getDentistasDisponibles(Request $request)
    {
        $fechaSeleccionada = Carbon::parse($request->fecha)->startOfDay(); // Aseguramos que solo tomamos el día, no la hora
        $horariosDisponibles = [];

        // Obtener los dentistas con el rol de 'Dentista'
        $dentistas = User::where('role', 'Dentista')->get();

        foreach ($dentistas as $dentista) {
            // Obtener los horarios laborales del dentista para el día seleccionado
            $horarios = Horarios_laborales::where('user_id', $dentista->id)
                ->whereDate('start_datetime', '<=', $fechaSeleccionada) // Verificamos si el turno incluye ese día
                ->whereDate('end_datetime', '>=', $fechaSeleccionada) // Verificamos si el turno incluye ese día
                ->get();

            foreach ($horarios as $horario) {
                // Obtener la hora de inicio y la de fin del horario laboral
                $start = Carbon::parse($horario->start_datetime);
                $end = Carbon::parse($horario->end_datetime);

                $horasDisponibles = [];
                // Generar las horas disponibles para ese día (de 30 minutos)
                while ($start->lt($end)) {
                    // Verificar si ya existe una cita en ese horario
                    $existeCita = Citas::where('fecha_hora', $start)->exists();
                    if (!$existeCita) {
                        $horasDisponibles[] = $start->format('H:i');
                    }
                    $start->addMinutes(30); // Incrementamos en intervalos de 30 minutos
                }

                // Si hay horas disponibles, agregar al array de horariosDisponibles
                if (!empty($horasDisponibles)) {
                    $horariosDisponibles[$dentista->id] = [
                        'nombre' => $dentista->name,  // Nombre del dentista
                        'apellido_p' => $dentista->apellido_p,  // apellido del dentista
                        'horas' => $horasDisponibles,
                    ];
                }
            }
        }

        return response()->json($horariosDisponibles);
    }
}
