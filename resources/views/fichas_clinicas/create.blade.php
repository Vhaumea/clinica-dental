@extends('adminlte::page')

@section('title', 'Crear Ficha Clínica')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Crear Ficha Clínica') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('fichas_clinicas.store') }}" method="POST">
                @csrf
                <!-- Campo oculto para el ID del paciente -->
                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                <!-- Primera fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                    <!-- Medicamentos en Tratamiento -->
                    <div class="mb-4">
                        <label for="medicamentos" class="block text-gray-700 font-medium">{{ __('Medicamentos en Tratamiento') }}</label>
                        <select id="medicamentos" name="medicamentos" class="form-control @error('medicamentos') is-invalid @enderror" required>
                            <option value="No">{{ __('No') }}</option>
                            <option value="Sí">{{ __('Sí') }}</option>
                        </select>
                        @error('medicamentos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Cuales Medicamentos -->
                    <div id="cuales_medicamentos_container" class="mb-4 hidden">
                        <label for="cuales_medicamentos" class="block text-gray-700 font-medium">{{ __('Cuales') }}</label>
                        <input id="cuales_medicamentos" type="text" class="form-control @error('cuales_medicamentos') is-invalid @enderror" name="cuales_medicamentos">
                        @error('cuales_medicamentos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Alergias -->
                    <div class="mb-4">
                        <label for="alergias" class="block text-gray-700 font-medium">{{ __('Alergias') }}</label>
                        <select id="alergias" name="alergias" class="form-control @error('alergias') is-invalid @enderror" required>
                            <option value="No">{{ __('No') }}</option>
                            <option value="Sí">{{ __('Sí') }}</option>
                        </select>
                        @error('alergias')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Cuales Alergias -->
                    <div id="cuales_alergias_container" class="mb-4 hidden">
                        <label for="cuales_alergias" class="block text-gray-700 font-medium">{{ __('Cuales') }}</label>
                        <input id="cuales_alergias" type="text" class="form-control @error('cuales_alergias') is-invalid @enderror" name="cuales_alergias">
                        @error('cuales_alergias')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Embarazo -->
                    <div class="mb-4">
                        <label for="embarazo" class="block text-gray-700 font-medium">{{ __('¿Está embarazada?') }}</label>
                        <select id="embarazo" name="embarazo" class="form-control @error('embarazo') is-invalid @enderror" required>
                            <option value="0">{{ __('No') }}</option>
                            <option value="1">{{ __('Sí') }}</option>
                        </select>
                        @error('embarazo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Tiempo de Gestación -->
                    <div id="tiempo_gestacion_container" class="mb-4 hidden">
                        <label for="tiempo_gestacion" class="block text-gray-700 font-medium">{{ __('Tiempo de Gestación (semanas)') }}</label>
                        <input id="tiempo_gestacion" type="number" class="form-control @error('tiempo_gestacion') is-invalid @enderror" name="tiempo_gestacion">
                        @error('tiempo_gestacion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Segunda fila -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Enfermedades Sistémicas -->
                    <div class="mb-4">
                        <label for="enfermedades_sistemicas" class="block text-gray-700 font-medium">{{ __('¿Tiene enfermedades sistémicas?') }}</label>
                        <select id="enfermedades_sistemicas" name="enfermedades_sistemicas" class="form-control @error('enfermedades_sistemicas') is-invalid @enderror" required>
                            <option value="No">{{ __('No') }}</option>
                            <option value="Sí">{{ __('Sí') }}</option>
                        </select>
                        @error('enfermedades_sistemicas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Cuales Enfermedades Sistémicas -->
                    <div id="cuales_enfermedades_sistemicas_container" class="mb-4 hidden">
                        <label for="cuales_enfermedades_sistemicas" class="block text-gray-700 font-medium">{{ __('Cuales') }}</label>
                        <input id="cuales_enfermedades_sistemicas" type="text" class="form-control @error('cuales_enfermedades_sistemicas') is-invalid @enderror" name="cuales_enfermedades_sistemicas">
                        @error('cuales_enfermedades_sistemicas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Hipertensión -->
                    <div class="mb-4">
                        <label for="hipertension" class="block text-gray-700 font-medium">{{ __('¿Tiene hipertensión?') }}</label>
                        <select id="hipertension" name="hipertension" class="form-control @error('hipertension') is-invalid @enderror" required>
                            <option value="0">{{ __('No') }}</option>
                            <option value="1">{{ __('Sí') }}</option>
                        </select>
                        @error('hipertension')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Diabetes -->
                    <div class="mb-4">
                        <label for="diabetes" class="block text-gray-700 font-medium">{{ __('¿Tiene diabetes?') }}</label>
                        <select id="diabetes" name="diabetes" class="form-control @error('diabetes') is-invalid @enderror" required>
                            <option value="No">{{ __('No') }}</option>
                            <option value="Sí">{{ __('Sí') }}</option>
                        </select>
                        @error('diabetes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Tipo de Diabetes -->
                    <div id="tipo_diabetes_container" class="mb-4 hidden">
                        <label for="tipo_diabetes" class="block text-gray-700 font-medium">{{ __('Tipo de Diabetes') }}</label>
                        <input id="tipo_diabetes" type="text" class="form-control @error('tipo_diabetes') is-invalid @enderror" name="tipo_diabetes">
                        @error('tipo_diabetes')
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
                        <input id="otros" type="text" class="form-control @error('otros') is-invalid @enderror" name="otros">
                        @error('otros')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Reacción Alérgica a Medicamentos -->
                    <div class="mb-4">
                        <label for="reaccion_alergica_medicamento" class="block text-gray-700 font-medium">{{ __('Reacción Alérgica a Medicamentos') }}</label>
                        <select id="reaccion_alergica_medicamento" name="reaccion_alergica_medicamento" class="form-control @error('reaccion_alergica_medicamento') is-invalid @enderror" required>
                            <option value="No">{{ __('No') }}</option>
                            <option value="Sí">{{ __('Sí') }}</option>
                        </select>
                        @error('reaccion_alergica_medicamento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Cuales Reacción Alérgica a Medicamentos -->
                    <div id="cuales_reaccion_alergica_medicamento_container" class="mb-4 hidden">
                        <label for="cuales_reaccion_alergica_medicamento" class="block text-gray-700 font-medium">{{ __('Cuales') }}</label>
                        <input id="cuales_reaccion_alergica_medicamento" type="text" class="form-control @error('cuales_reaccion_alergica_medicamento') is-invalid @enderror" name="cuales_reaccion_alergica_medicamento">
                        @error('cuales_reaccion_alergica_medicamento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Reacción Alérgica a la Anestesia -->
                    <div class="mb-4">
                        <label for="reaccion_alergica_anestesia" class="block text-gray-700 font-medium">{{ __('Reacción Alérgica a la Anestesia') }}</label>
                        <select id="reaccion_alergica_anestesia" name="reaccion_alergica_anestesia" class="form-control @error('reaccion_alergica_anestesia') is-invalid @enderror" required>
                            <option value="No">{{ __('No') }}</option>
                            <option value="Sí">{{ __('Sí') }}</option>
                        </select>
                        @error('reaccion_alergica_anestesia')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Cuales Reacción Alérgica a la Anestesia -->
                    <div id="cuales_reaccion_alergica_anestesia_container" class="mb-4 hidden">
                        <label for="cuales_reaccion_alergica_anestesia" class="block text-gray-700 font-medium">{{ __('Cuales') }}</label>
                        <input id="cuales_reaccion_alergica_anestesia" type="text" class="form-control @error('cuales_reaccion_alergica_anestesia') is-invalid @enderror" name="cuales_reaccion_alergica_anestesia">
                        @error('cuales_reaccion_alergica_anestesia')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="mb-4">
                    <label for="observaciones" class="block text-gray-700 font-medium">{{ __('Observaciones') }}</label>
                    <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3"></textarea>
                    @error('observaciones')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Guardar Ficha Clínica') }}</button>
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

    //Medicamentos en tratamiento
    document.addEventListener('DOMContentLoaded', function() {
        const medicamentosSelect = document.getElementById('medicamentos');
        const cualesMedicamentosContainer = document.getElementById('cuales_medicamentos_container');
        const cualesMedicamentosInput = document.getElementById('cuales_medicamentos');

        medicamentosSelect.addEventListener('change', function() {
            if (medicamentosSelect.value === 'Sí') {
                cualesMedicamentosContainer.classList.remove('hidden');
                cualesMedicamentosInput.setAttribute('name', 'medicamentos'); // Cambiar el nombre del campo
            } else {
                cualesMedicamentosContainer.classList.add('hidden');
                cualesMedicamentosInput.removeAttribute('name'); // Remover el nombre del campo
                medicamentosSelect.setAttribute('name', 'medicamentos'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Cuales"
        if (medicamentosSelect.value === 'Sí') {
            cualesMedicamentosContainer.classList.remove('hidden');
            cualesMedicamentosInput.setAttribute('name', 'medicamentos'); // Cambiar el nombre del campo
        } else {
            cualesMedicamentosContainer.classList.add('hidden');
            cualesMedicamentosInput.removeAttribute('name'); // Remover el nombre del campo
            medicamentosSelect.setAttribute('name', 'medicamentos'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });
    //Alergias
    document.addEventListener('DOMContentLoaded', function() {
        const alergiasSelect = document.getElementById('alergias');
        const cualesAlergiasContainer = document.getElementById('cuales_alergias_container');
        const cualesAlergiasInput = document.getElementById('cuales_alergias');

        alergiasSelect.addEventListener('change', function() {
            if (alergiasSelect.value === 'Sí') {
                cualesAlergiasContainer.classList.remove('hidden');
                cualesAlergiasInput.setAttribute('name', 'alergias'); // Cambiar el nombre del campo
            } else {
                cualesAlergiasContainer.classList.add('hidden');
                cualesAlergiasInput.removeAttribute('name'); // Remover el nombre del campo
                alergiasSelect.setAttribute('name', 'alergias'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Cuales"
        if (alergiasSelect.value === 'Sí') {
            cualesAlergiasContainer.classList.remove('hidden');
            cualesAlergiasInput.setAttribute('name', 'alergias'); // Cambiar el nombre del campo
        } else {
            cualesAlergiasContainer.classList.add('hidden');
            cualesAlergiasInput.removeAttribute('name'); // Remover el nombre del campo
            alergiasSelect.setAttribute('name', 'alergias'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const enfermedadesSistemicasSelect = document.getElementById('enfermedades_sistemicas');
        const cualesEnfermedadesSistemicasContainer = document.getElementById('cuales_enfermedades_sistemicas_container');
        const cualesEnfermedadesSistemicasInput = document.getElementById('cuales_enfermedades_sistemicas');

        enfermedadesSistemicasSelect.addEventListener('change', function() {
            if (enfermedadesSistemicasSelect.value === 'Sí') {
                cualesEnfermedadesSistemicasContainer.classList.remove('hidden');
                cualesEnfermedadesSistemicasInput.setAttribute('required', 'required'); // Hacer el campo requerido
                enfermedadesSistemicasSelect.removeAttribute('name'); // Remover el nombre del campo select
                cualesEnfermedadesSistemicasInput.setAttribute('name', 'enfermedades_sistemicas'); // Cambiar el nombre del campo de texto
            } else {
                cualesEnfermedadesSistemicasContainer.classList.add('hidden');
                cualesEnfermedadesSistemicasInput.removeAttribute('required'); // Remover el atributo requerido
                cualesEnfermedadesSistemicasInput.removeAttribute('name'); // Remover el nombre del campo de texto
                enfermedadesSistemicasSelect.setAttribute('name', 'enfermedades_sistemicas'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Cuales"
        if (enfermedadesSistemicasSelect.value === 'Sí') {
            cualesEnfermedadesSistemicasContainer.classList.remove('hidden');
            cualesEnfermedadesSistemicasInput.setAttribute('required', 'required'); // Hacer el campo requerido
            enfermedadesSistemicasSelect.removeAttribute('name'); // Remover el nombre del campo select
            cualesEnfermedadesSistemicasInput.setAttribute('name', 'enfermedades_sistemicas'); // Cambiar el nombre del campo de texto
        } else {
            cualesEnfermedadesSistemicasContainer.classList.add('hidden');
            cualesEnfermedadesSistemicasInput.removeAttribute('required'); // Remover el atributo requerido
            cualesEnfermedadesSistemicasInput.removeAttribute('name'); // Remover el nombre del campo de texto
            enfermedadesSistemicasSelect.setAttribute('name', 'enfermedades_sistemicas'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const diabetesSelect = document.getElementById('diabetes');
        const tipoDiabetesContainer = document.getElementById('tipo_diabetes_container');
        const tipoDiabetesInput = document.getElementById('tipo_diabetes');

        diabetesSelect.addEventListener('change', function() {
            if (diabetesSelect.value === 'Sí') {
                tipoDiabetesContainer.classList.remove('hidden');
                tipoDiabetesInput.setAttribute('name', 'diabetes'); // Cambiar el nombre del campo de texto
                diabetesSelect.removeAttribute('name'); // Remover el nombre del campo select
            } else {
                tipoDiabetesContainer.classList.add('hidden');
                tipoDiabetesInput.removeAttribute('name'); // Remover el nombre del campo de texto
                diabetesSelect.setAttribute('name', 'diabetes'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Tipo de Diabetes"
        if (diabetesSelect.value === 'Sí') {
            tipoDiabetesContainer.classList.remove('hidden');
            tipoDiabetesInput.setAttribute('name', 'diabetes'); // Cambiar el nombre del campo de texto
            diabetesSelect.removeAttribute('name'); // Remover el nombre del campo select
        } else {
            tipoDiabetesContainer.classList.add('hidden');
            tipoDiabetesInput.removeAttribute('name'); // Remover el nombre del campo de texto
            diabetesSelect.setAttribute('name', 'diabetes'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });

    //otros
    document.addEventListener('DOMContentLoaded', function() {
        const otrosSelect = document.getElementById('otros');
        const cualesOtrosContainer = document.getElementById('cuales_otros_container');
        const cualesOtrosInput = document.getElementById('cuales_otros');

        otrosSelect.addEventListener('change', function() {
            if (otrosSelect.value === 'Sí') {
                cualesOtrosContainer.classList.remove('hidden');
                cualesOtrosInput.setAttribute('name', 'otros'); // Cambiar el nombre del campo
            } else {
                cualesOtrosContainer.classList.add('hidden');
                cualesOtrosInput.removeAttribute('name'); // Remover el nombre del campo
                otrosSelect.setAttribute('name', 'otros'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Cuales"
        if (otrosSelect.value === 'Sí') {
            cualesOtrosContainer.classList.remove('hidden');
            cualesOtrosInput.setAttribute('name', 'otros'); // Cambiar el nombre del campo
        } else {
            cualesOtrosContainer.classList.add('hidden');
            cualesOtrosInput.removeAttribute('name'); // Remover el nombre del campo
            otrosSelect.setAttribute('name', 'otros'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });

    //reaccion alergica a medicamentos
    document.addEventListener('DOMContentLoaded', function() {
        const reaccionAlergicaMedicamentoSelect = document.getElementById('reaccion_alergica_medicamento');
        const cualesReaccionAlergicaMedicamentoContainer = document.getElementById('cuales_reaccion_alergica_medicamento_container');
        const cualesReaccionAlergicaMedicamentoInput = document.getElementById('cuales_reaccion_alergica_medicamento');

        reaccionAlergicaMedicamentoSelect.addEventListener('change', function() {
            if (reaccionAlergicaMedicamentoSelect.value === 'Sí') {
                cualesReaccionAlergicaMedicamentoContainer.classList.remove('hidden');
                cualesReaccionAlergicaMedicamentoInput.setAttribute('name', 'reaccion_alergica_medicamento'); // Cambiar el nombre del campo
            } else {
                cualesReaccionAlergicaMedicamentoContainer.classList.add('hidden');
                cualesReaccionAlergicaMedicamentoInput.removeAttribute('name'); // Remover el nombre del campo
                reaccionAlergicaMedicamentoSelect.setAttribute('name', 'reaccion_alergica_medicamento'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Cuales"
        if (reaccionAlergicaMedicamentoSelect.value === 'Sí') {
            cualesReaccionAlergicaMedicamentoContainer.classList.remove('hidden');
            cualesReaccionAlergicaMedicamentoInput.setAttribute('name', 'reaccion_alergica_medicamento'); // Cambiar el nombre del campo
        } else {
            cualesReaccionAlergicaMedicamentoContainer.classList.add('hidden');
            cualesReaccionAlergicaMedicamentoInput.removeAttribute('name'); // Remover el nombre del campo
            reaccionAlergicaMedicamentoSelect.setAttribute('name', 'reaccion_alergica_medicamento'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });

    //reaccion alergica a la anestesia
    document.addEventListener('DOMContentLoaded', function() {
        const reaccionAlergicaAnestesiaSelect = document.getElementById('reaccion_alergica_anestesia');
        const cualesReaccionAlergicaAnestesiaContainer = document.getElementById('cuales_reaccion_alergica_anestesia_container');
        const cualesReaccionAlergicaAnestesiaInput = document.getElementById('cuales_reaccion_alergica_anestesia');

        reaccionAlergicaAnestesiaSelect.addEventListener('change', function() {
            if (reaccionAlergicaAnestesiaSelect.value === 'Sí') {
                cualesReaccionAlergicaAnestesiaContainer.classList.remove('hidden');
                cualesReaccionAlergicaAnestesiaInput.setAttribute('name', 'reaccion_alergica_anestesia'); // Cambiar el nombre del campo
            } else {
                cualesReaccionAlergicaAnestesiaContainer.classList.add('hidden');
                cualesReaccionAlergicaAnestesiaInput.removeAttribute('name'); // Remover el nombre del campo
                reaccionAlergicaAnestesiaSelect.setAttribute('name', 'reaccion_alergica_anestesia'); // Asegurarse de que el campo select tenga el nombre correcto
            }
        });

        // Inicializar la visibilidad del campo "Cuales"
        if (reaccionAlergicaAnestesiaSelect.value === 'Sí') {
            cualesReaccionAlergicaAnestesiaContainer.classList.remove('hidden');
            cualesReaccionAlergicaAnestesiaInput.setAttribute('name', 'reaccion_alergica_anestesia'); // Cambiar el nombre del campo
        } else {
            cualesReaccionAlergicaAnestesiaContainer.classList.add('hidden');
            cualesReaccionAlergicaAnestesiaInput.removeAttribute('name'); // Remover el nombre del campo
            reaccionAlergicaAnestesiaSelect.setAttribute('name', 'reaccion_alergica_anestesia'); // Asegurarse de que el campo select tenga el nombre correcto
        }
    });
</script>
@endsection