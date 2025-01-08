<?php

namespace App\Http\Controllers;

use App\Models\FichaClinica;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class FichaClinicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($paciente_id)
    {
        $paciente = Pacientes::findOrFail($paciente_id);
        return view('fichas_clinicas.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medicamentos' => 'nullable|string',
            'alergias' => 'nullable|string',
            'embarazo' => 'required|boolean',
            'tiempo_gestacion' => 'nullable|integer',
            'enfermedades_sistemicas' => 'required|string',
            'hipertension' => 'required|boolean',
            'diabetes' => 'required|string',
            'otros' => 'nullable|string',
            'reaccion_alergica_medicamento' => 'nullable|string',
            'reaccion_alergica_anestesia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        FichaClinica::create($request->all());

        return redirect()->route('pacientes.edit', ['id' => $request->paciente_id, 'modo' => 'ver'])->with('message', 'Ficha clínica creada con éxito.');
    }


    public function edit($id)
    {
        $fichaClinica = FichaClinica::findOrFail($id);
        $paciente = $fichaClinica->paciente;
        return view('fichas_clinicas.edit', compact('fichaClinica', 'paciente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medicamentos' => 'nullable|string',
            'alergias' => 'nullable|string',
            'embarazo' => 'required|boolean',
            'tiempo_gestacion' => 'nullable|integer',
            'enfermedades_sistemicas' => 'required|string',
            'hipertension' => 'required|boolean',
            'diabetes' => 'required|string',
            'otros' => 'nullable|string',
            'reaccion_alergica_medicamento' => 'nullable|string',
            'reaccion_alergica_anestesia' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $fichaClinica = FichaClinica::findOrFail($id);
        $fichaClinica->update($request->all());

        return redirect()->route('pacientes.edit', ['id' => $request->paciente_id, 'modo' => 'ver'])->with('message', 'Ficha actualizada  con éxito.');
    }

}
