<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\Horarios_laboralesController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\DetallePresupuestoController;
use App\Http\Controllers\Notas_EvolucionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\FichaClinicaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'checkStatus']], function () {
    // Rutas protegidas
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // Añade aquí otras rutas protegidas
});

// USUARIO
Route::get('/configuracion', [UserController::class, 'config'])->name('config');
Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename?}', [UserController::class, 'getImage'])->name('user.avatar');
Route::put('/user/change-password', [UserController::class, 'changePassword'])->name('user.change-password');

// USUARIOS
Route::get('users/index', [UsersController::class, 'index'])->name('users.index');
Route::get('users/create', [UsersController::class, 'crear'])->name('users.crear');
Route::post('users/create', [UsersController::class, 'store'])->name('users.store');
Route::get('users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
Route::put('users/edit/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
Route::patch('/users/{id}/toggle-status', [UsersController::class, 'toggleStatus'])->name('users.toggleStatus');



//PACIENTES

Route::get('pacientes/crear', [PacienteController::class, 'crear'])->name('pacientes.crear');
Route::post('pacientes/crear', [PacienteController::class, 'store'])->name('pacientes.store');
Route::get('pacientes/index', [PacienteController::class, 'index'])->name('pacientes.index');
Route::put('pacientes/edit/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
Route::get('pacientes/edit/{id}', [PacienteController::class, 'edit'])->name('pacientes.edit');
Route::delete('pacientes/{id}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');
Route::patch('/pacientes/{id}/toggleStatus', [PacienteController::class, 'toggleStatus'])->name('pacientes.toggleStatus');
Route::get('pacientes/edit/{id}', [PacienteController::class, 'edit'])->name('pacientes.edit');



//Horario de usuarios
Route::get('horarios_laborales/index', [Horarios_laboralesController::class, 'index'])->name('horarios_laborales.index');
Route::get('horarios_laborales/create', [Horarios_laboralesController::class, 'create'])->name('horarios_laborales.create');
Route::post('horarios_laborales/create', [Horarios_laboralesController::class, 'store'])->name('horarios_laborales.store');
Route::get('horarios_laborales/edit/{id}', [Horarios_laboralesController::class, 'edit'])->name('horarios_laborales.edit');
Route::put('horarios_laborales/edit/{id}', [Horarios_laboralesController::class, 'update'])->name('horarios_laborales.update');
Route::delete('horarios_laborales/{id}', [Horarios_laboralesController::class, 'destroy'])->name('horarios_laborales.destroy');
Route::get('horarios_laborales/calendar', [Horarios_laboralesController::class, 'calendar'])->name('horarios_laborales.calendar');
Route::patch('/horarios_laborales/{id}/toggleStatus', [Horarios_laboralesController::class, 'toggleStatus'])->name('horarios_laborales.toggleStatus');




//Citas
Route::resource('citas', CitasController::class);
Route::get('/get-presupuestos/{pacienteId}', [CitasController::class, 'getPresupuestos']);
Route::get('citas/{id}/edit-horarios', [CitasController::class, 'edit'])->name('horarios.citas.edit');
Route::get('/get-horarios-disponibles', [CitasController::class, 'getHorariosDisponibles']);
Route::get('citas/create/{paciente_id?}/{presupuesto_id?}', [CitasController::class, 'create'])->name('citas.create');

// Rutas para Notas de Evolución
Route::prefix('notas-evolucion')->group(function () {
    Route::get('/', [Notas_EvolucionController::class, 'index'])->name('notas_evolucion.index');
    Route::get('/create', [Notas_EvolucionController::class, 'create'])->name('notas_evolucion.create');
    Route::post('/', [Notas_EvolucionController::class, 'store'])->name('notas_evolucion.store');
    Route::get('/{id}/edit', [Notas_EvolucionController::class, 'edit'])->name('notas_evolucion.edit');
    Route::patch('/{id}', [Notas_EvolucionController::class, 'update'])->name('notas_evolucion.update');
    Route::delete('/{id}', [Notas_EvolucionController::class, 'destroy'])->name('notas_evolucion.destroy');
    Route::get('/{cita_id}', [Notas_EvolucionController::class, 'show'])->name('notas_evolucion.show');
    Route::patch('/{id}/toggle-status', [Notas_EvolucionController::class, 'toggleStatus'])->name('notas_evolucion.toggleStatus');

});
Route::resource('notas_evolucion', Notas_EvolucionController::class);
//Presupuestos y sus detalles
Route::get('presupuestos/index-manual', [PresupuestoController::class, 'index'])->name('presupuestos.index.manual');
Route::resource('presupuestos', PresupuestoController::class);
Route::get('/pacientes/{paciente}/presupuestos', [PresupuestoController::class, 'index'])->name('pacientes.presupuestos.index');
Route::get('/detalles-presupuesto', [DetallePresupuestoController::class, 'index'])->name('detalles-presupuesto.index');
Route::post('detalles/store', [DetallePresupuestoController::class, 'store'])->name('detalles.store');
Route::get('/detalles/{id}/edit', [DetallePresupuestoController::class, 'edit'])->name('detalles.edit');
Route::put('/detalles/{id}', [DetallePresupuestoController::class, 'update'])->name('detalles.update');
Route::post('/detalles-presupuesto/store', [DetallePresupuestoController::class, 'store'])->name('detalles-presupuesto.store');




Route::get('abonos/create/{presupuesto_id}', [AbonoController::class, 'create'])->name('abonos.create');
Route::post('abonos', [AbonoController::class, 'store'])->name('abonos.store');
Route::get('abonos/{id}/edit', [AbonoController::class, 'edit'])->name('abonos.edit');
Route::put('abonos/{id}', [AbonoController::class, 'update'])->name('abonos.update');


Route::get('fichas_clinicas/create/{paciente_id}', [FichaClinicaController::class, 'create'])->name('fichas_clinicas.create');
Route::resource('fichas_clinicas', FichaClinicaController::class)->except(['create']);
