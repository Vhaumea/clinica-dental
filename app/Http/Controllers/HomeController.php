<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacientes;
use App\Models\Citas;
use App\Models\Presupuesto;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalPacientes = Pacientes::count();
        $totalCitasHoy = Citas::whereDate('fecha', today())->count();
        $totalCitasAyer = Citas::whereDate('fecha', today()->subDay())->count();
        $totalCitasManana = Citas::whereDate('fecha', today()->addDay())->count();

        $citas = Citas::with(['paciente', 'user'])->get();

        $facebook = Citas::where('medio', 'Facebook')->count();
        $whatsapp = Citas::where('medio', 'Whatsapp')->count();
        $presencial = Citas::where('medio', 'Presencial')->count();
        $telefono = Citas::where('medio', 'Telefono')->count();

        $pendientes = Citas::where('estado', 'Pendiente')->count();
        $confirmadas = Citas::where('estado', 'Confirmada')->count();
        $completadas = Citas::where('estado', 'Completada')->count();
        $canceladas = Citas::where('estado', 'Cancelada')->count();

        // Contar presupuestos completados y pendientes
        $presupuestosCompletados = Presupuesto::where('estado', 'Completado')->count();
        $presupuestosPendientes = Presupuesto::where('estado', 'Pendiente')->count();
        $presupuestosEnproceso = Presupuesto::where('estado', 'En proceso')->count();
        $presupuestosRechazados = Presupuesto::where('estado', 'Rechazado')->count();

        
        return view('home', compact(
            'totalPacientes', 
            'totalCitasHoy', 
            'totalCitasAyer', 
            'totalCitasManana', 
            'citas', 
            'whatsapp', 
            'facebook', 
            'presencial', 
            'telefono',
            'pendientes', 
            'confirmadas', 
            'completadas', 
            'canceladas',
            'presupuestosCompletados',
            'presupuestosPendientes',
            'presupuestosEnproceso',
            'presupuestosRechazados'
        ));
    }
}
