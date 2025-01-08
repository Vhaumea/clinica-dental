<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Nota_Evolucion;
use App\Models\Citas;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Horarios_laborales;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{ public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Mostrar todas las citas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $citas = Citas::all();
        return view('citas.index', compact('citas'));
    }

    /**
     * Mostrar el formulario para crear una nueva cita.
     *
     * @return \Illuminate\View\View
     */
    public function create($paciente_id = null, $presupuesto_id = null)
    {
        // Obtener solo los usuarios con el rol de 'Dentista' que tienen horarios laborales
        $dentistas = User::where('role', 'Dentista')
            ->whereHas('horarios_laborales')
            ->get();

        // Obtener todos los pacientes
        $pacientes = Pacientes::all();

        // Obtener el paciente seleccionado si se proporciona un ID
        $pacienteSeleccionado = null;
        if ($paciente_id) {
            $pacienteSeleccionado = Pacientes::find($paciente_id);
        }

        // Obtener el presupuesto seleccionado si se proporciona un ID y existe un paciente seleccionado
        $presupuestoSeleccionado = null;
        $presupuestos = collect(); // Inicializar como colección vacía
        if ($pacienteSeleccionado && $presupuesto_id) {
            $presupuestoSeleccionado = Presupuesto::find($presupuesto_id);
            if ($presupuestoSeleccionado) {
                $presupuestos->push($presupuestoSeleccionado); // Agregar el presupuesto seleccionado a la colección
            }
        } else {
            // Obtener todos los presupuestos si no se proporciona un presupuesto_id
            $presupuestos = Presupuesto::all();
        }

        // Pasar los datos a la vista
        return view('citas.create', compact('pacientes', 'dentistas', 'presupuestos', 'pacienteSeleccionado', 'presupuestoSeleccionado'));
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
            'medio' => 'required|in:Presencial,Telefono,Whatsapp,Facebook',
            'observaciones' => 'nullable|string',
            'estado' => 'in:Pendiente',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear una nueva cita
        $cita = Citas::create([
            'paciente_id' => $request->paciente_id,
            'presupuesto_id' => $request->presupuesto_id,
            'fecha' => $request->fecha,
            'user_id' => $request->user_id,
            'hora' => $request->hora,
            'motivo' => $request->motivo,
            'origen' => $request->origen,
            'medio' => $request->medio,
            'observaciones' => $request->observaciones,
            'estado' => $request->estado ?: 'Pendiente',
        ]);

        return redirect()->route('citas.index')->with(['message' => 'Hora Agendada con éxito']);
    }

    /**
     * Mostrar el formulario para editar una cita existente.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $cita = Citas::findOrFail($id); // Obtener cita por id
        $notasEvolucion = Nota_Evolucion::where('cita_id', $id)->get(); // Obtener notas de evolución para la cita

        $modo = $request->query('modo', 'ver'); // Por defecto es 'ver'
        // Retornar la vista con los datos del usuario
        return view('citas.edit', compact('cita', 'modo', 'notasEvolucion')); // Retorna la vista de edición con la cita a editar
    }

    /**
     * Actualizar una cita existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'observaciones' => 'nullable|string|max:255',
            'estado' => 'in:Pendiente,Confirmada,Cancelada,Completada, No asistio',
        ]);

        $cita = Citas::findOrFail($id);

        // Actualizar los datos de la cita
        $cita->update([
            'observaciones' => $request->observaciones,
            'estado' => $request->estado,
            'presupuesto_id' => $request->presupuesto_id ?: null, 
        ]);
        
        // Redirigir a la edición de la cita con el modo 'editar'
        return redirect()->route('citas.edit', ['cita' => $id, 'modo' => 'editar'])->with(['message' => 'Cita actualizada con éxito']);
    }

    /**
     * Eliminar una cita de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
 

    public function getPresupuestos($pacienteId)
    {
        // Obtener solo los presupuestos con estado 'Pendiente' o 'En Proceso'
        $presupuestos = Presupuesto::where('paciente_id', $pacienteId)
            ->whereIn('estado', ['Pendiente', 'En proceso'])
            ->get();

        return response()->json($presupuestos);
    }

    public function getHorariosDisponibles(Request $request)
    {
        $dentistaId = $request->input('dentista_id');
        $fecha = Carbon::parse($request->input('fecha'))->startOfDay();
        $now = Carbon::now();

        // Obtener los horarios laborales del dentista para el día seleccionado
        $horarios = Horarios_laborales::where('user_id', $dentistaId)
            ->where('estado', 'Activo')
            ->whereDate('start_datetime', '<=', $fecha)
            ->whereDate('end_datetime', '>=', $fecha)
            ->get();

        $horasDisponibles = [];
        foreach ($horarios as $horario) {
            $start = Carbon::parse($horario->start_datetime);
            $end = Carbon::parse($horario->end_datetime);

            // Generar las horas disponibles para ese día (de 30 minutos)
            while ($start->lt($end)) {
                // Verificar si ya existe una cita en ese horario
                $existeCita = Citas::where('user_id', $dentistaId)

                    ->whereDate('fecha', $fecha)
                    ->whereTime('hora', $start->format('H:i:s'))
                    ->where('estado', '!=', 'Cancelada')
                    ->exists();

                // Verificar si la hora ya ha pasado y si no existe una cita en ese horario
                if (!$existeCita && ($fecha->isToday() ? $start->gt($now) : true)) {
                    $horasDisponibles[] = $start->format('H:i');
                }

                $start->addMinutes(30); // Incrementamos en intervalos de 30 minutos
            }
        }

        return response()->json(['horarios' => $horasDisponibles]);
    }
}
