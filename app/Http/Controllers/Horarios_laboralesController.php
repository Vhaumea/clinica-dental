<?php

namespace App\Http\Controllers;
use DateTime;
use App\Models\Horarios_laborales;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
class Horarios_laboralesController extends Controller
{
   // Mostrar todos los horarios laborales
   public function index()
   {
       $horarios = Horarios_laborales::with('user')->orderBy('start_datetime', 'desc')->get();
       return view('horarios_laborales.index', compact('horarios'));
   }

   // Mostrar el formulario para crear un nuevo horario
   public function create()
   {
       $users = User::all(); // Obtener todos los usuarios
       return view('horarios_laborales.create', compact('users'));
   }

   // Método para crear un nuevo horario
   public function store(Request $request)
   {
       // Validación de los datos
       // Validación de los datos
       $validator = Validator::make($request->all(), [
           'user_id' => 'required|exists:users,id',
           'start_datetime' => 'required|date',
           'end_datetime' => 'required|date|after:start_datetime',
           'estado' => 'required|in:Activo,Inactivo',
           'notes' => 'nullable|string',
           'schedule_type' => 'required|in:Normal,Extra,Vacaciones',
       ]);
       // Convierte las cadenas a objetos DateTime
       try {
           $startDate = new DateTime($request->start_datetime);
           $endDate = new DateTime($request->end_datetime);
       } catch (Exception $e) {
           return redirect()->back()->withErrors(['start_datetime' => 'Fecha de inicio inválida.', 'end_datetime' => 'Fecha de fin inválida.'])->withInput();
       }
       // Obtener la fecha del inicio del horario
       $startDate = \Carbon\Carbon::parse($request->start_datetime)->format('Y-m-d');
       $userId = $request->user_id;

       // Verificar si ya existe un horario para este usuario en la misma fecha
       $existingSchedule = Horarios_laborales::where('user_id', $userId)
           ->whereDate('start_datetime', $startDate)
           ->first();

       if ($existingSchedule) {
           return redirect()->route('horarios_laborales.store')->with(['error' => 'El usuario ya tiene un horario para este día']);
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
       $horarios = Horarios_laborales::findOrFail($id); // Obtener el horario por ID
       $users = User::all(); // Obtener todos los usuarios
       $modo = $request->query('modo', 'ver'); // Por defecto es 'ver'
       // Retornar la vista con los datos del usuario
       return view('horarios_laborales.edit', compact('horarios', 'users', 'modo'));
   }

   // Actualizar un horario laboral existente
   public function update(Request $request, $id)
   {
       $request->validate([
           'start_datetime' => 'required|date',
           'end_datetime' => 'required|date|after:start_datetime',
           'estado' => 'required|in:Activo,Inactivo',
           'notes' => 'nullable|string',
           'schedule_type' => 'nullable|in:Normal,Extra,Vacaciones',
       ]);

       $horarios = Horarios_laborales::findOrFail($id);
       $horarios->update($request->all());

       return redirect()->route('horarios_laborales.index')->with('message', 'Horario laboral actualizado correctamente.');
   }

   // Eliminar un horario laboral existente
   public function destroy($id)
   {
       $horarios = Horarios_laborales::findOrFail($id);
       $horarios->delete();

       return redirect()->route('horarios_laborales.index')->with('message', 'Horario laboral eliminado correctamente.');
   }

   // Mostrar el calendario de horarios laborales
   public function calendar()
   {
       $horarios = Horarios_laborales::with('user')->get(); // Obtener todos los horarios laborales
       return view('horarios_laborales.calendar', compact('horarios'))->with('isCalendar', true);
   }
}
