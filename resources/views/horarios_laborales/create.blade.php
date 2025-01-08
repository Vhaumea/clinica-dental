@extends('adminlte::page')
@section('title', 'Crear Horario Laboral')

@section('content')
@if(Auth::check() && Auth::user()->isAdmin())
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Crear Horario Laboral') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <!-- Barra de progreso -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="0">1</div>
                    <div class="w-8 h-1 bg-gray-200"></div>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="1">2</div>
                    <div class="w-8 h-1 bg-gray-200"></div>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="2">3</div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('horarios_laborales.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4 mb-4 text-black">

                    <div id="step1" class="step">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información del Usuario') }}</h3>

                        <!-- Campo de entrada para buscar el RUT del usuario -->
                        <div class="row mb-3">
                            <label for="rut_user" class="col-md-4 col-form-label text-md-end">{{ __('RUT del Usuario') }}</label>
                            <div class="col-md-6">
                                <input id="rut_user" type="text" class="form-control @error('rut_user') is-invalid @enderror" name="rut_user" autocomplete="off" required>

                                @error('rut_user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Lista de coincidencias para mostrar mientras se escribe -->
                                <div id="rut_suggestions" class="list-group mt-1"></div>
                            </div>
                        </div>

                        <!-- Campo oculto para almacenar el ID del usuario -->
                        <input type="hidden" id="user_id" name="user_id">

                        <!-- Campo para mostrar el nombre del usuario basado en el RUT seleccionado -->
                        <div class="row mb-3">
                            <label for="nombre_user" class="col-md-4 col-form-label text-md-end">{{ __('Nombre del Usuario') }}</label>
                            <div class="col-md-6">
                                <input id="nombre_user" type="text" class="form-control" name="nombre_user" readonly>
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button" class="btn-next bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Siguiente') }}</button>
                        </div>
                    </div>

                    <div id="step2" class="step hidden">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Detalles del Horario') }}</h3>
                        <div class="row mb-3">
                            <label for="start_datetime" class="col-md-4 col-form-label text-md-end">{{ __('Hora de Inicio') }}</label>
                            <div class="col-md-6">
                                <input type="datetime-local" id="start_datetime" name="start_datetime" class="form-control @error('start_datetime') is-invalid @enderror" required />
                                @error('start_datetime')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span id="start_datetime_error" class="text-danger" style="display: none;">Por favor, seleccione una hora antes de continuar.</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end_datetime" class="col-md-4 col-form-label text-md-end">{{ __('Hora de Término') }}</label>
                            <div class="col-md-6">
                                <input type="datetime-local" name="end_datetime" id="end_datetime" class="form-control @error('end_datetime') is-invalid @enderror" required />
                                @error('end_datetime')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span id="end_datetime_error" class="text-danger" style="display: none;">Por favor, seleccione una hora antes de continuar.</span>
                                <span id="datetime_match_error" class="text-danger" style="display: none;">La hora de inicio y la hora de término no pueden ser iguales.</span>
                            </div>
                        </div>

                        <div class="flex justify-between mt-4">
                            <button type="button" class="btn-prev bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Anterior') }}</button>
                            <button type="button" class="btn-next bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Siguiente') }}</button>
                        </div>
                    </div>

                    <div id="step3" class="step hidden">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Notas y Confirmación') }}</h3>
                        <div class="row mb-3">
                            <label for="notes" class="col-md-4 col-form-label text-md-end">{{ __('Notas Adicionales') }}</label>
                            <div class="col-md-6">
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"></textarea>
                                @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="schedule_type" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de Horario') }}</label>
                            <div class="col-md-6">
                                <select id="schedule_type" name="schedule_type" class="form-control @error('schedule_type') is-invalid @enderror" required>
                                    <option value="Normal" selected>Normal</option>
                                    <option value="Extra">Extra</option>
                                </select>
                                @error('schedule_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Campo oculto para enviar el estado -->
                        <input type="hidden" name="estado" value="Activo">

                        <div class="flex justify-between mt-4">
                            <button type="button" class="btn-prev bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Anterior') }}</button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600">
                                {{ __('Registrar') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    
    // JavaScript para manejar la navegación entre pasos y la barra de progreso
    document.addEventListener("DOMContentLoaded", function() {
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.btn-next');
        const prevButtons = document.querySelectorAll('.btn-prev');
        const stepCircles = document.querySelectorAll('.step-circle');
        let currentStep = 0;

        // Mostrar el primer paso
        steps[currentStep].classList.remove('hidden');
        updateProgressBar();

        nextButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                // Validar el formulario actual
                const inputs = steps[currentStep].querySelectorAll('input, select, textarea');
                let valid = true;
                for (const input of inputs) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        valid = false;
                        break; // Detener la validación en el primer campo inválido
                    }
                }

                // Validar que se haya seleccionado una hora de inicio y una hora de término
                const startDatetimeInput = document.getElementById('start_datetime');
                const endDatetimeInput = document.getElementById('end_datetime');
                const startDatetimeError = document.getElementById('start_datetime_error');
                const endDatetimeError = document.getElementById('end_datetime_error');
                const datetimeMatchError = document.getElementById('datetime_match_error');

                if (currentStep === 1) {
                    if (!startDatetimeInput.value) {
                        startDatetimeError.style.display = 'block';
                        startDatetimeInput.classList.add('is-invalid');
                        valid = false;
                    } else {
                        startDatetimeError.style.display = 'none';
                        startDatetimeInput.classList.remove('is-invalid');
                    }

                    if (!endDatetimeInput.value) {
                        endDatetimeError.style.display = 'block';
                        endDatetimeInput.classList.add('is-invalid');
                        valid = false;
                    } else {
                        endDatetimeError.style.display = 'none';
                        endDatetimeInput.classList.remove('is-invalid');
                    }

                    if (startDatetimeInput.value && endDatetimeInput.value && startDatetimeInput.value === endDatetimeInput.value) {
                        datetimeMatchError.style.display = 'block';
                        valid = false;
                    } else {
                        datetimeMatchError.style.display = 'none';
                    }
                }

                if (valid) {
                    // Ocultar el paso actual
                    steps[currentStep].classList.add('hidden');
                    // Avanzar al siguiente paso
                    currentStep++;
                    // Mostrar el siguiente paso si existe
                    if (currentStep < steps.length) {
                        steps[currentStep].classList.remove('hidden');
                    }
                    updateProgressBar();
                }
            });
        });

        prevButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                // Ocultar el paso actual
                steps[currentStep].classList.add('hidden');
                // Retroceder al paso anterior
                currentStep--;
                // Mostrar el paso anterior si existe
                if (currentStep >= 0) {
                    steps[currentStep].classList.remove('hidden');
                }
                updateProgressBar();
            });
        });

        function updateProgressBar() {
            stepCircles.forEach((circle, index) => {
                if (index <= currentStep) {
                    circle.classList.add('bg-blue-500', 'text-white');
                    circle.classList.remove('bg-gray-200', 'text-black');
                } else {
                    circle.classList.add('bg-gray-200', 'text-black');
                    circle.classList.remove('bg-blue-500', 'text-white');
                }
            });
        }

        // Inicializar Flatpickr en los campos de fecha y hora
        const startDatetimePicker = flatpickr("#start_datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today", // Establecer la fecha mínima en hoy
            onChange: function(selectedDates, dateStr, instance) {
                // Copiar la fecha y hora de inicio a la fecha y hora de fin
                endDatetimePicker.setDate(dateStr);
            }
        });

        const endDatetimePicker = flatpickr("#end_datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today" // Establecer la fecha mínima en hoy
        });

        // Autocompletar para el campo de usuario
        const rutInput = document.getElementById('rut_user');
        const nombreInput = document.getElementById('nombre_user');
        const suggestions = document.getElementById('rut_suggestions');

        const userIdInput = document.getElementById('user_id');

        // Lista de users cargados desde el backend
        const users = @json($users);

        // Mostrar sugerencias de RUT
        rutInput.addEventListener('input', function() {
            const search = rutInput.value.toLowerCase();
            suggestions.innerHTML = '';

            // Filtrar users según el RUT ingresado
            const filtered = users.filter(u => u.rut.toLowerCase().includes(search));

            // Limitar a las primeras 3 sugerencias
            const limitedSuggestions = filtered.slice(0, 3);

            limitedSuggestions.forEach(user => {
                const option = document.createElement('a');
                option.href = '#';
                option.className = 'list-group-item list-group-item-action';
                option.textContent = `${user.rut} - ${user.name} ${user.apellido_p} ${user.apellido_m} - ${user.role}`; // Mostrar RUT y nombre completo
                option.dataset.nombre = `${user.name} ${user.apellido_p} ${user.apellido_m}`;
                option.dataset.id = user.id; // Almacena el ID en un dataset

                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    rutInput.value = user.rut; // Muestra el RUT en el input
                    nombreInput.value = option.dataset.nombre; // Muestra el nombre completo en el input
                    userIdInput.value = option.dataset.id; // Asigna el ID al campo oculto
                    suggestions.innerHTML = ''; // Limpia las sugerencias
                });

                suggestions.appendChild(option);
            });
        });

        // Limpiar sugerencias cuando se selecciona el campo
        rutInput.addEventListener('focus', () => suggestions.innerHTML = '');
    });
</script>
@else
<div class="alert alert-danger">
    No tienes los permisos.
</div>
<script>
    setTimeout(function() {
        window.location.href = "{{ url('/') }}";
    }, 3000); // Redirige después de 3 segundos
</script>
@endif
@endsection