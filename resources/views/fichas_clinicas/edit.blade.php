@extends('adminlte::page')

@section('title', 'Editar Ficha Clínica')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Editar Ficha Clínica') }}</h2>
        </div>
        <div class="card-body p-6 bg-white">
            <form action="{{ route('fichas_clinicas.update', $fichaClinica->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo oculto para el ID del paciente -->
                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                <!-- Primera fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                    <!-- Medicamentos en Tratamiento -->
                    <div class="mb-4">
                        <label for="medicamentos" class="block text-sm font-medium text-gray-700">{{ __('Medicamentos en Tratamiento') }}</label>
                        <input id="medicamentos" type="text" class="form-control mt-1 block w-full @error('medicamentos') is-invalid @enderror" name="medicamentos" value="{{ $fichaClinica->medicamentos }}" required autofocus>
                        @error('medicamentos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Alergias -->
                    <div class="mb-4">
                        <label for="alergias" class="block text-sm font-medium text-gray-700">{{ __('Alergias') }}</label>
                        <input id="alergias" type="text" class="form-control mt-1 block w-full @error('alergias') is-invalid @enderror" name="alergias" value="{{ $fichaClinica->alergias }}" required autofocus>
                        @error('alergias')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <!-- Embarazo -->
                    <div class="mb-4">
                        <label for="embarazo" class="block text-gray-700 font-medium">{{ __('¿Está embarazada?') }}</label>
                        <select id="embarazo" name="embarazo" class="form-control @error('embarazo') is-invalid @enderror" required>
                            <option value="0" {{ $fichaClinica->embarazo == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                            <option value="1" {{ $fichaClinica->embarazo == 1 ? 'selected' : '' }}>{{ __('Sí') }}</option>
                        </select>
                        @error('embarazo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Tiempo de Gestación -->
                    <div id="tiempo_gestacion_container" class="mb-4 {{ $fichaClinica->embarazo == 1 ? '' : 'hidden' }}">
                        <label for="tiempo_gestacion" class="block text-gray-700 font-medium">{{ __('Tiempo de Gestación (semanas)') }}</label>
                        <input id="tiempo_gestacion" type="number" class="form-control @error('tiempo_gestacion') is-invalid @enderror" name="tiempo_gestacion" value="{{ $fichaClinica->tiempo_gestacion }}">
                        @error('tiempo_gestacion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Segunda fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                    <!-- enfermedades_sistemicas -->
                    <div class="mb-4">
                        <label for="enfermedades_sistemicas" class="block text-sm font-medium text-gray-700">{{ __('¿Tiene enfermedades sistémicas?') }}</label>
                        <input id="enfermedades_sistemicas" type="text" class="form-control mt-1 block w-full @error('enfermedades_sistemicas') is-invalid @enderror" name="enfermedades_sistemicas" value="{{ $fichaClinica->enfermedades_sistemicas }}" required autofocus>
                        @error('enfermedades_sistemicas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Hipertensión -->
                    <div class="mb-4">
                        <label for="hipertension" class="block text-gray-700 font-medium">{{ __('¿Tiene hipertensión?') }}</label>
                        <select id="hipertension" name="hipertension" class="form-control @error('hipertension') is-invalid @enderror" required>
                            <option value="0" {{ $fichaClinica->hipertension == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                            <option value="1" {{ $fichaClinica->hipertension == 1 ? 'selected' : '' }}>{{ __('Sí') }}</option>
                        </select>
                        @error('hipertension')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Diabetes -->
                    <div class="mb-4">
                        <label for="diabetes" class="block text-sm font-medium text-gray-700">{{ __('¿Tiene diabetes?') }}</label>
                        <input id="diabetes" type="text" class="form-control mt-1 block w-full @error('diabetes') is-invalid @enderror" name="diabetes" value="{{ $fichaClinica->diabetes }}" required autofocus>
                        @error('diabetes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>

                <!-- Tercera fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Otros -->
                    <div class="mb-4">
                        <label for="otros" class="block text-gray-700 font-medium">{{ __('Otros') }}</label>
                        <input id="otros" type="text" class="form-control @error('otros') is-invalid @enderror" name="otros" value="{{ $fichaClinica->otros }}">
                        @error('otros')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Reacción Alérgica a Medicamentos -->
                    <div class="mb-4">
                        <label for="reaccion_alergica_medicamento" class="block text-sm font-medium text-gray-700">{{ __('Reacción Alérgica a Medicamentos') }}</label>
                        <input id="reaccion_alergica_medicamento" type="text" class="form-control mt-1 block w-full @error('reaccion_alergica_medicamento') is-invalid @enderror" name="reaccion_alergica_medicamento" value="{{ $fichaClinica->reaccion_alergica_medicamento }}" required autofocus>
                        @error('reaccion_alergica_medicamento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Reacción Alérgica a Medicamentos -->
                    <div class="mb-4">
                        <label for="reaccion_alergica_anestesia" class="block text-sm font-medium text-gray-700">{{ __('Reacción Alérgica a la Anestesia') }}</label>
                        <input id="reaccion_alergica_anestesia" type="text" class="form-control mt-1 block w-full @error('reaccion_alergica_anestesia') is-invalid @enderror" name="reaccion_alergica_anestesia" value="{{ $fichaClinica->reaccion_alergica_anestesia }}" required autofocus>
                        @error('reaccion_alergica_anestesia')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="mb-4">
                    <label for="observaciones" class="block text-gray-700 font-medium">{{ __('Observaciones') }}</label>
                    <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3">{{ $fichaClinica->observaciones }}</textarea>
                    @error('observaciones')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Guardar Cambios') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    //Embarazo
    document.addEventListener('DOMContentLoaded', function() {
        const embarazoSelect = document.getElementById('embarazo');
        const tiempoGestacionContainer = document.getElementById('tiempo_gestacion_container');

        embarazoSelect.addEventListener('change', function() {
            if (embarazoSelect.value === '1') {
                tiempoGestacionContainer.classList.remove('hidden');
            } else {
                tiempoGestacionContainer.classList.add('hidden');
            }
        });

        // Inicializar la visibilidad del campo "Tiempo de Gestación"
        if (embarazoSelect.value === '1') {
            tiempoGestacionContainer.classList.remove('hidden');
        } else {
            tiempoGestacionContainer.classList.add('hidden');
        }
    });

</script>
@endsection