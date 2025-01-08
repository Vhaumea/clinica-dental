<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Horarios_laborales;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class Horarios_laboralesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Mostrar todos los horarios laborales
    public function index()
    {
        $horarios = Horarios_laborales::with('user')->orderBy('start_datetime', 'desc')->get();
        return view('horarios_laborales.index', compact('horarios'));
    }

    // Mostrar el formulario para crear un nuevo horario
    public function create()
    {
        $users = User::where('estado', 'Activo')->get();
        return view('horarios_laborales.create', compact('users'));
    }

    // Método para crear un nuevo horario
    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'notes' => 'nullable|string',
            'schedule_type' => 'required|in:Normal,Extra',
            'estado' => 'required|in:Activo,Inactivo',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Convierte las cadenas a objetos DateTime
        try {
            $startDate = new DateTime($request->start_datetime);
            $endDate = new DateTime($request->end_datetime);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['start_datetime' => 'Fecha de inicio inválida.', 'end_datetime' => 'Fecha de fin inválida.'])
            ->withInput();
        }
    
        // Obtener la fecha del inicio del horario
        $startDate = \Carbon\Carbon::parse($request->start_datetime)->format('Y-m-d');
        $userId = $request->user_id;
    
        // Verificar si ya existe un horario para este usuario en la misma fecha
        $existingSchedule = Horarios_laborales::where('user_id', $userId)
            ->whereDate('start_datetime', $startDate)
            ->first();
    
        if ($existingSchedule) {
            return redirect()->back()->withErrors(['start_datetime' => 'El usuario ya tiene un horario para este día.'])->withInput();
        }
    
        // Crear el nuevo horario laboral
        Horarios_laborales::create([
            'user_id' => $request->user_id,
            'start_datetime' => new DateTime($request->start_datetime),
            'end_datetime' => new DateTime($request->end_datetime),
            'estado' => $request->estado,
            'notes' => $request->notes,
            'schedule_type' => $request->schedule_type,
        ]);
    
        return redirect()->route('horarios_laborales.index')->with(['message' => 'Horario laboral creado con éxito']);
    }

    // Mostrar el formulario para editar un horario existente
    public function edit($id, Request $request)
    {
        $horarios = Horarios_laborales::findOrFail($id);
        $users = User::all();
        $modo = $request->query('modo', 'ver');

        // Verificar si el usuario no es Admin y está intentando acceder al modo editar
        if (Auth::user()->role !== 'Admin' && $modo === 'editar') {
            return redirect()->route('horarios_laborales.edit', ['id' => $id, 'modo' => 'ver']);
        }

        return view('horarios_laborales.edit', compact('horarios', 'users', 'modo'));
    }

    // Actualizar un horario laboral existente

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'schedule_type' => 'required|string',
            'estado' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Obtener el horario por ID
        $horarios = Horarios_laborales::findOrFail($id);


        // Actualizar los datos del horario
        $horarios->start_datetime = $request->input('start_datetime');
        $horarios->end_datetime = $request->input('end_datetime');
        $horarios->notes = $request->input('notes');
        $horarios->schedule_type = $request->input('schedule_type');
        $horarios->estado = $request->input('estado');

        // Guardar los cambios
        $horarios->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('horarios_laborales.edit', ['id' => $id])
            ->with('message', 'Horario actualizado correctamente');
    }

  

    public function toggleStatus($id)
    {
        $horario = Horarios_laborales::findOrFail($id);
        $horario->estado = $horario->estado === 'Activo' ? 'Inactivo' : 'Activo';

        $horario->save();

        return redirect()->route('horarios_laborales.index')->with('message', 'Estado del horario actualizado correctamente.');
    }

    // Mostrar el calendario de horarios laborales
    public function calendar()
    {
        $horarios = Horarios_laborales::with('user')->where('estado', 'Activo')->get(); // Obtener solo los horarios laborales con estado activo
        return view('horarios_laborales.calendar', compact('horarios'))->with('isCalendar', true);
    }
}
