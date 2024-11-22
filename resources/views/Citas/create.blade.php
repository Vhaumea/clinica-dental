@extends('adminlte::page')

@section('title', 'Crear Cita')

@section('content')

<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Reserva de horas') }}</div>
        <div class="card-body">
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <!-- Campo de entrada para buscar el RUT del paciente -->
                <div class="row mb-3">
                    <label for="rut_paciente" class="col-md-4 col-form-label text-md-end">{{ __('RUT del Paciente') }}</label>
                    <div class="col-md-6">
                        <input id="rut_paciente" type="text" class="form-control @error('rut_paciente') is-invalid @enderror" name="rut_paciente" autocomplete="off" required>

                        @error('rut_paciente')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <!-- Lista de coincidencias para mostrar mientras se escribe -->
                        <div id="rut_suggestions" class="list-group mt-1"></div>
                    </div>
                </div>

                <!-- Campo oculto para almacenar el ID del paciente -->
                <input type="hidden" id="paciente_id" name="paciente_id">

                <!-- Campo para mostrar el nombre del paciente basado en el RUT seleccionado -->
                <div class="row mb-3">
                    <label for="nombre_paciente" class="col-md-4 col-form-label text-md-end">{{ __('Nombre del Paciente') }}</label>
                    <div class="col-md-6">
                        <input id="nombre_paciente" type="text" class="form-control" name="nombre_paciente" readonly>
                    </div>
                </div>

                <!-- Campo de selección de presupuestos -->
                <div class="row mb-3">
                    <label for="presupuesto_id" class="col-md-4 col-form-label text-md-end">{{ __('Presupuesto') }}</label>

                    <div class="col-md-6">
                        <select id="presupuestos" class="form-control @error('presupuestos') is-invalid @enderror" name="presupuesto_id">
                            <option value="">Sin presupuesto</option>
                        </select>

                        @error('presupuesto_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>



                <!-- Campo de selección de fecha -->
                <div class="row mb-3">
                    <label for="fecha" class="col-md-4 col-form-label text-md-end">{{ __('Fecha') }}</label>
                    <div class="col-md-6">
                        <input type="date" id="fecha" class="form-control" name="fecha" required>
                    </div>
                </div>

                <!-- Mostrar dentistas y horas disponibles -->
                <div id="dentistas_disponibles" class="row mb-3" style="display:none;">
                    <label for="user_id" class="col-md-4 col-form-label text-md-end">{{ __('Dentistas') }}</label>
                    <div class="col-md-6">
                        <select id="dentista" name="user_id" class="form-control" required>
                            <option value="">Seleccione un dentista</option>
                        </select>
                    </div>
                </div>


                <div id="horas_disponibles" class="row mb-3" style="display:none;">
                    <label for="hora" class="col-md-4 col-form-label text-md-end">{{ __('Hora') }}</label>
                    <div class="col-md-6">
                        <select id="hora" name="hora" class="form-control" required>
                            <option value="">Seleccione una hora</option>
                        </select>
                    </div>
                </div>

                <!-- Campo de motivo -->
                <div class="row mb-3">
                    <label for="motivo" class="col-md-4 col-form-label text-md-end">{{ __('Motivo') }}</label>
                    <div class="col-md-6">
                        <input id="motivo" type="text" class="form-control @error('motivo') is-invalid @enderror" name="motivo" value="{{ old('motivo') }}" maxlength="255" autofocus>
                        @error('motivo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Campo de origen -->
                <div class="row mb-3">
                    <label for="origen" class="col-md-4 col-form-label text-md-end">{{ __('Origen') }}</label>
                    <div class="col-md-6">
                        <select id="origen" class="form-control @error('origen') is-invalid @enderror" name="origen" required>
                            <option value="">Seleccione el origen</option>
                            <option value="Urgencia" {{ old('origen') == 'Urgencia' ? 'selected' : '' }}>Urgencia</option>
                            <option value="Presupuesto" {{ old('origen') == 'Presupuesto' ? 'selected' : '' }}>Presupuesto</option>
                            <option value="Consulta" {{ old('origen') == 'Consulta' ? 'selected' : '' }}>Consulta</option>
                        </select>
                        @error('origen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Observaciones -->
                <div class="row mb-3">
                    <label for="observaciones" class="col-md-4 col-form-label text-md-end">{{ __('Observaciones') }}</label>
                    <div class="col-md-6">
                        <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones"></textarea>
                        @error('observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Campo de estado -->
                <div class="row mb-3">
                    <label for="estado" class="col-md-4 col-form-label text-md-end">{{ __('Estado') }}</label>
                    <div class="col-md-6">
                        <select id="estado" class="form-control @error('estado') is-invalid @enderror" name="estado" required>
                            <option value="Pendiente" {{ old('estado', 'Pendiente') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Botón de submit -->
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Registrar Cita') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="max-w-2xl mx-auto px-4 py-6">
        <div class="mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="SanaSalud" class="h-8 mx-auto">
            <h1 class="text-2xl text-center mt-4">SanaSalud</h1>
            <h2 class="text-xl text-center text-gray-600">Reserva de horas</h2>
        </div>

        {{-- Progress Steps --}}
        <div class="flex items-center justify-between mb-8 px-4">
            <div class="w-full flex items-center">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white">✓</div>
                <div class="flex-grow h-1 mx-4 bg-blue-500"></div>
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white"></div>
                <div class="flex-grow h-1 mx-4 bg-gray-200"></div>
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-gray-200"></div>
                <div class="flex-grow h-1 mx-4 bg-gray-200"></div>
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-gray-200"></div>
            </div>
        </div>

        {{-- Doctor Info Card --}}
        <div class="bg-white rounded-lg shadow-sm p-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-xl">
                    A
                </div>
                <div>
                    <h3 class="text-lg font-medium">Dra {{ $doctor->name ?? 'Alanis Maldonado' }}</h3>
                    <p class="text-gray-600">General</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="font-medium">Sucursal Santiago Centro</p>
                <p class="text-gray-600">Sanasalud Vivo Centro</p>
                <p class="mt-2">Duración 30 minutos</p>
            </div>
        </div>

        {{-- Calendar Section --}}
        <div class="mb-6">
            <h3 class="text-lg mb-4">Semana del 20 al 26 de enero</h3>
            <div class="grid grid-cols-7 gap-2 mb-6">
                @foreach(['LUN', 'MAR', 'MIÉ', 'JUE', 'VIE', 'SÁB', 'DOM'] as $index => $day)
                <div class="text-center {{ $index === 4 ? 'bg-blue-500 text-white rounded-lg p-2' : 'bg-gray-50 rounded-lg p-2' }}">
                    <div class="text-sm">{{ $day }}</div>
                    <div class="font-medium">{{ 20 + $index }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Time Slots --}}
        <div class="mb-6">
            <h3 class="text-lg mb-4">Viernes 24 de enero</h3>
            <div class="flex gap-4 mb-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Todos los horarios</button>
                <button class="bg-gray-100 px-4 py-2 rounded-lg">Mañana</button>
                <button class="bg-gray-100 px-4 py-2 rounded-lg">Tarde</button>
            </div>

            <div class="grid grid-cols-4 gap-4">
                @foreach(['09:15', '09:45', '10:15', '10:45', '11:15', '11:45', '12:15', '14:15', '14:45', '15:15', '15:45', '16:15', '16:45', '17:15', '17:45', '18:15'] as $time)
                <button class="bg-gray-50 hover:bg-gray-100 p-3 rounded-lg text-center">
                    {{ $time }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Reserve Button --}}
        <button class="w-full bg-blue-500 text-white py-4 rounded-lg text-lg font-medium">
            Reservar
        </button>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rutInput = document.getElementById('rut_paciente');
        const nombreInput = document.getElementById('nombre_paciente');
        const suggestions = document.getElementById('rut_suggestions');
        const presupuestosSelect = document.getElementById('presupuestos');
        const pacienteIdInput = document.getElementById('paciente_id'); // Campo oculto para el ID

        // Lista de pacientes cargados desde el backend
        const pacientes = @json($pacientes);

        // Mostrar sugerencias de RUT
        rutInput.addEventListener('input', function() {
            const search = rutInput.value.toLowerCase();
            suggestions.innerHTML = '';

            // Filtrar pacientes según el RUT ingresado
            const filtered = pacientes.filter(p => p.rut.toLowerCase().includes(search));

            // Limitar a las primeras 3 sugerencias
            const limitedSuggestions = filtered.slice(0, 3);

            limitedSuggestions.forEach(paciente => {
                const option = document.createElement('a');
                option.href = '#';
                option.className = 'list-group-item list-group-item-action';
                option.textContent = `${paciente.rut} - ${paciente.nombre} ${paciente.apellido_p}`; // Mostrar RUT y nombre completo
                option.dataset.nombre = `${paciente.nombre} ${paciente.apellido_p} ${paciente.apellido_m}`;
                option.dataset.id = paciente.id; // Almacena el ID en un dataset

                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    rutInput.value = paciente.rut; // Muestra el RUT en el input
                    nombreInput.value = option.dataset.nombre; // Muestra el nombre completo en el input
                    pacienteIdInput.value = option.dataset.id; // Asigna el ID al campo oculto
                    suggestions.innerHTML = ''; // Limpia las sugerencias

                });

                suggestions.appendChild(option);
            });
        });

        // Limpiar sugerencias cuando se selecciona el campo
        rutInput.addEventListener('focus', () => suggestions.innerHTML = '');
    });
    $(document).ready(function() {
        // Cuando el usuario selecciona una fecha
        $('#fecha').change(function() {
            let fechaSeleccionada = $(this).val();

            // Hacer una solicitud AJAX al backend para obtener los dentistas y sus horas disponibles
            $.ajax({
                url: '/get-dentistas-disponibles',
                method: 'GET',
                data: {
                    fecha: fechaSeleccionada
                },
                success: function(response) {
                    // Limpiar los campos de dentistas y horas
                    $('#dentista').empty();
                    $('#hora').empty();

                    if (Object.keys(response).length === 0) {
                        alert('No hay dentistas disponibles para este día.');
                        $('#dentistas_disponibles').hide();
                        $('#horas_disponibles').hide();
                    } else {
                        // Mostrar dentistas y sus horas
                        $('#dentistas_disponibles').show();
                        $('#horas_disponibles').show();

                        // Llenar el select de dentistas disponibles
                        $('#dentista').append('<option value="">Seleccione un dentista</option>');
                        $.each(response, function(dentistaId, dentistaData) {
                            // Concatenar nombre y apellido
                            let nombreCompleto = dentistaData.nombre + ' ' + dentistaData.apellido_p;
                            // Agregar la opción al select
                            $('#dentista').append('<option value="' + dentistaId + '">' + nombreCompleto + '</option>');
                        });
                    }
                }
            });
        });


        // Cuando el usuario selecciona un dentista
        $('#dentista').change(function() {
            let dentistaId = $(this).val();
            let fechaSeleccionada = $('#fecha').val();

            if (dentistaId) {
                // Llenar las horas disponibles para el dentista seleccionado
                $('#hora').empty();
                $('#hora').append('<option value="">Seleccione una hora</option>');

                $.ajax({
                    url: '/get-dentistas-disponibles',
                    method: 'GET',
                    data: {
                        fecha: fechaSeleccionada,
                        dentista_id: dentistaId
                    },
                    success: function(response) {
                        // Llenar el select de horas
                        if (response[dentistaId]) {
                            $.each(response[dentistaId].horas, function(index, hora) {
                                $('#hora').append('<option value="' + hora + '">' + hora + '</option>');
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
