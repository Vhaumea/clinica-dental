@extends('adminlte::page')

@section('title', 'Crear Cita')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Agenda de horas') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <!-- Barra de progreso -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="0">1</div>
                    <div class="w-8 h-1 bg-gray-200"></div>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="1">2</div>
                </div>
            </div>
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4 mb-4 text-black">

                    <div id="step1" class="step">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información del Paciente') }}</h3>

                        <!-- Campo de entrada para buscar el RUT del paciente -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="rut_paciente" class="col-form-label text-md-end">{{ __('RUT del Paciente') }}</label>
                                <input id="rut_paciente" type="text" class="form-control @error('rut_paciente') is-invalid @enderror" name="rut_paciente" autocomplete="off" required>
                                @error('rut_paciente')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <!-- Lista de coincidencias para mostrar mientras se escribe -->
                                <div id="rut_suggestions" class="list-group mt-1"></div>
                            </div>

                            <!-- Campo oculto para almacenar el ID del paciente -->
                            <input type="hidden" id="paciente_id" name="paciente_id">

                            <div class="col-md-4">
                                <label for="nombre_paciente" class="col-form-label text-md-end">{{ __('Nombre del Paciente') }}</label>
                                <input id="nombre_paciente" type="text" class="form-control" name="nombre_paciente" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="presupuesto_id" class="col-form-label text-md-end">{{ __('Presupuesto') }}</label>
                                <select id="presupuestos" class="form-control @error('presupuestos') is-invalid @enderror" name="presupuesto_id">
                                    <option value="">Sin presupuesto</option>
                                    @foreach($presupuestos as $presupuesto)
                                    <option value="{{ $presupuesto->id }}"
                                        @if(isset($presupuestoSeleccionado) && $presupuestoSeleccionado->id == $presupuesto->id)
                                        selected
                                        @endif>
                                        ID: {{ $presupuesto->id }} - {{ $presupuesto->estado }} - {{ $presupuesto->fecha }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('presupuesto_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div style="margin-top: 1cm;">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Disponibilidad del Dentista') }}</h3>
                        </div>
                        <!-- Mostrar dentistas disponibles -->
                        <div id="dentistas_disponibles" class="row mb-3">
                            @foreach($dentistas as $dentista)
                            <div class="dentista-card bg-white rounded-lg shadow-sm p-4 mb-8 cursor-pointer mx-2" data-dentista-id="{{ $dentista->id }}">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-xl">
                                        @if($dentista->foto)
                                        <img src="{{ $dentista->foto }}" alt="{{ $dentista->name }}" class="rounded-full w-full h-full object-cover">
                                        @else
                                        {{ strtoupper(substr($dentista->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium">{{ $dentista->name }}</h3>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Campo oculto para almacenar el ID del dentista -->
                        <input type="hidden" id="user_id" name="user_id">

                        <!-- Mostrar calendario de disponibilidad -->
                        <div id="calendario_disponibilidad" class="hidden">
                            <div class="mb-6">
                                <h3 class="text-lg mb-4" id="week-range"></h3>
                                <div class="flex justify-between items-center mb-4">

                                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg" id="prev-week">
                                        < </button>

                                            <div class="grid grid-cols-7 gap-2 mb-6 flex-grow" id="calendar-week">
                                                <!-- Aquí se llenará dinámicamente -->
                                            </div>
                                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg" id="next-week"> > </button>
                                </div>
                            </div>
                            <div class="mb-6">
                                <h3 class="text-lg mb-4" id="selected-day"></h3>
                                <div class="flex gap-4 mb-4">
                                    <button type="button" class="bg-gray-100 px-4 py-2 rounded-lg time-button selected-button" id="all-times">Todos los horarios</button>
                                    <button type="button" class="bg-gray-100 px-4 py-2 rounded-lg time-button" id="morning-times">Mañana</button>
                                    <button type="button" class="bg-gray-100 px-4 py-2 rounded-lg time-button" id="afternoon-times">Tarde</button>
                                </div>
                                <div class="grid grid-cols-4 gap-4" id="time-slots">
                                    <!-- Aquí se llenará dinámicamente -->
                                </div>
                            </div>
                        </div>
                        <!-- Campo oculto para almacenar la fecha seleccionada -->
                        <input type="hidden" id="fecha" name="fecha" required>
                        <input type="hidden" id="hora" name="hora" required>
                        <div id="hora-error" class="invalid-feedback text-red-500 hidden">Por favor, seleccione una hora antes de continuar.</div>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="btn-next bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Siguiente') }}</button>
                        </div>

                    </div>
                    <div id="step2" class="step hidden">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información Adicional') }}</h3>

                        <!-- Campo para origen -->
                        <div class="row mb-3">
                            <label for="origen" class="col-md-4 col-form-label text-md-end">{{ __('Origen') }}</label>
                            <div class="col-md-6">
                                <select id="origen" class="form-control @error('origen') is-invalid @enderror" name="origen" required>
                                    <option value="Urgencia">Urgencia</option>
                                    <option value="Presupuesto">Presupuesto</option>
                                    <option value="Consulta">Consulta</option>
                                </select>
                                @error('origen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Campo para motivo -->
                        <div class="row mb-3">
                            <label for="motivo" class="col-md-4 col-form-label text-md-end">{{ __('Motivo') }}</label>
                            <div class="col-md-6">
                                <input id="motivo" type="text" class="form-control @error('motivo') is-invalid @enderror" name="motivo" required minlength="2">
                                @error('motivo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span id="motivo_error" class="text-danger" style="display: none;">El motivo debe tener al menos dos letras.</span>
                            </div>
                        </div>

                        <!-- Campo para medio -->
                        <div class="row mb-3">
                            <label for="medio" class="col-md-4 col-form-label text-md-end">{{ __('Medio') }}</label>
                            <div class="col-md-6">
                                <select id="medio" class="form-control @error('medio') is-invalid @enderror" name="medio" required>
                                    <option value="Presencial">Presencial</option>
                                    <option value="Telefono">Telefono</option>
                                    <option value="Whatsapp">WhatsApp</option>
                                    <option value="Facebook">Facebook</option>
                                </select>
                                @error('medio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Campo oculto para estado -->
                        <input type="hidden" id="estado" name="estado" value="Pendiente">

                        <!-- Campo para observaciones -->
                        <div class="row mb-3">
                            <label for="observaciones" class="col-md-4 col-form-label text-md-end">{{ __('Observaciones') }}</label>
                            <div class="col-md-6">
                                <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3" required minlength="2"></textarea>
                                @error('observaciones')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span id="observaciones_error" class="text-danger" style="display: none;">Las observaciones deben tener al menos dos letras.</span>
                            </div>
                        </div>

                        <div class="flex justify-between mt-4">
                            <button type="button" class="btn-prev bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Anterior') }}</button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600">
                                {{ __('Registrar Cita') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const rutInput = document.getElementById('rut_paciente');
        const nombreInput = document.getElementById('nombre_paciente');
        const suggestions = document.getElementById('rut_suggestions');
        const presupuestosSelect = document.getElementById('presupuestos');
        const pacienteIdInput = document.getElementById('paciente_id'); // Campo oculto para el ID

        // Función para obtener y mostrar los presupuestos del paciente seleccionado
        function obtenerPresupuestos(pacienteId) {
            $.ajax({
                url: `/get-presupuestos/${pacienteId}`, // Asegúrate de que esta URL sea correcta
                method: 'GET',
                success: function(response) {
                    // Limpiar el campo de selección de presupuestos
                    presupuestosSelect.innerHTML = '<option value="">Sin presupuesto</option>';

                    // Agregar los presupuestos al campo de selección
                    response.forEach(presupuesto => {
                        const option = document.createElement('option');
                        option.value = presupuesto.id;
                        option.textContent = `ID: ${presupuesto.id} - ${presupuesto.estado} - ${presupuesto.fecha}`; // Incluir el nombre del tratamiento
                        presupuestosSelect.appendChild(option);
                    });

                    // Seleccionar el presupuesto si está definido
                    @if(isset($presupuestoSeleccionado))
                    presupuestosSelect.value = "{{ $presupuestoSeleccionado->id }}";
                    @endif
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los presupuestos:', error);
                    console.log(xhr.responseText); // Muestra la respuesta del servidor para depuración
                }
            });
        }

        // Si hay un paciente seleccionado, autocompletar los campos
        @if(isset($pacienteSeleccionado))
        rutInput.value = "{{ $pacienteSeleccionado->rut }}";
        nombreInput.value = "{{ $pacienteSeleccionado->nombre }} {{ $pacienteSeleccionado->apellido_p }} {{ $pacienteSeleccionado->apellido_m }}";
        pacienteIdInput.value = "{{ $pacienteSeleccionado->id }}";
        obtenerPresupuestos("{{ $pacienteSeleccionado->id }} ");
        @endif

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

                    // Obtener presupuestos del paciente seleccionado
                    obtenerPresupuestos(paciente.id);
                });

                suggestions.appendChild(option);
            });
        });

        // Limpiar sugerencias cuando se selecciona el campo
        rutInput.addEventListener('focus', () => suggestions.innerHTML = '');
    });

    const horaInput = document.getElementById('hora'); // Campo oculto para la hora

    // Rango de la semana 
    let currentWeekStart = new Date();
    currentWeekStart.setDate(currentWeekStart.getDate() - currentWeekStart.getDay() + 1);

    const today = new Date();
    today.setHours(0, 0, 0, 0); // Resetear la hora para comparar solo la fecha
  
    // Función para obtener el rango de la semana actual
    function getWeekRange(date) {
        const firstDay = new Date(date);
        const lastDay = new Date(date);
        lastDay.setDate(lastDay.getDate() + 6);
        const options = {
            month: 'long',
            day: 'numeric'
        };

        return `${firstDay.toLocaleDateString('es-ES', options)} - ${lastDay.toLocaleDateString('es-ES', options)}`;
    }

    // Mostrar el rango de la semana actual
    function updateWeekRange() {
        if ($('#user_id').val()) { // Verificar si se ha seleccionado un dentista
            $('#week-range').text(`Semana del ${getWeekRange(currentWeekStart)}`);
            updateCalendarWeek();
            updatePrevButtonState();
            $('#prev-week, #next-week, #all-times, #morning-times, #afternoon-times').show(); // Mostrar los botones
        } else {
            $('#week-range').text(''); // Limpiar el rango de la semana
            $('#prev-week, #next-week, #all-times, #morning-times, #afternoon-times').hide(); // Ocultar los botones
        }
    }

    // Deshabilitar el botón de semana anterior si la semana actual es la semana de la fecha actual o una semana posterior
    function updatePrevButtonState() {
        $('#prev-week').prop('disabled', currentWeekStart <= today);
    }

    // Mostrar el rango de la semana actual al cargar la página
    updateWeekRange();

    // Manejar clic en el botón de semana anterior
    $('#prev-week').click(function() {
        currentWeekStart.setDate(currentWeekStart.getDate() - 7);
        updateWeekRange();
    });

    // Manejar clic en el botón de semana siguiente
    $('#next-week').click(function() {
        currentWeekStart.setDate(currentWeekStart.getDate() + 7);
        updateWeekRange();
    });

    // Función para actualizar el rango de la semana y resaltar el día actual
    function updateCalendarWeek() {
        const weekDays = ['LUN', 'MAR', 'MIÉ', 'JUE', 'VIE', 'SÁB', 'DOM'];
        const weekContainer = $('#calendar-week');
        weekContainer.empty();

        weekDays.forEach((day, index) => {
    const dayDate = new Date(currentWeekStart);
    dayDate.setDate(currentWeekStart.getDate() + index);
// probar 
    // Restar tres horas
  //  dayDate.setHours(dayDate.getHours() - 1);
  //dejado en prueba
    dayDate.setHours(0, 0, 0, 0);
    const isToday = dayDate.toDateString() === today.toDateString();
    
    // Obtener el día del mes después de restar las horas
    const dayOfMonth = dayDate.getDate();

    const dayElement = `<div class="text-center day-card bg-gray-50 rounded-lg p-2 ${isToday ? 'bg-blue-500 text-white' : ''}" data-date="${dayDate.toISOString().split('T')[0]}">
                <div class="text-sm">${day}</div>
                <div class="font-medium">${dayOfMonth}</div>
            </div>`;
    weekContainer.append(dayElement);
});

        // Manejar clic en un día del calendario
        $('#calendar-week').off('click').on('click', '.day-card', function() {
            const selectedDate = new Date($(this).data('date'));
            // Sumar un día a la fecha seleccionada
            selectedDate.setDate(selectedDate.getDate() + 1);
            
            // Ajustar la fecha a la zona horaria deseada (por ejemplo, 'America/Santiago')
            const timezoneOffset = selectedDate.getTimezoneOffset() * 60000; // Offset en milisegundos
            const localDate = new Date(selectedDate.getTime() - timezoneOffset);

            $('#fecha').val(localDate.toISOString().split('T')[0]); // Actualizar el campo oculto con la fecha seleccionada

            if (localDate < today) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No puedes seleccionar un día pasado.',
                    confirmButtonText: 'Cerrar'
                });
                return;
            }
            $('#selected-day').text(localDate.toLocaleDateString('es-ES', {
                weekday: 'long',
                month: 'long',
                day: 'numeric'
            }));

            // Marcar el día seleccionado
            $('.day-card').removeClass('bg-blue-500 text-white selected');
            $(this).addClass('bg-blue-500 text-white selected');

            // Simular clic en el botón "Todos los horarios" para mostrar todos los horarios por defecto
            $('#all-times').click();

        });
    }

    // Cuando el usuario selecciona un dentista en el paso 3
    $('.dentista-card').click(function() {
        let dentistaId = $(this).data('dentista-id');
        $('#user_id').val(dentistaId); // Actualizar el campo oculto con el ID del dentista
        $('#calendario_disponibilidad').addClass('hidden');

        // Hacer una solicitud AJAX al backend para obtener los horarios disponibles del dentista
        $.ajax({
            url: '/get-horarios-disponibles',
            method: 'GET',
            data: {
                dentista_id: dentistaId
            },
            success: function(response) {
                // Actualizar el calendario de disponibilidad con los horarios del dentista
                updateCalendar(response);
                $('#calendario_disponibilidad').removeClass('hidden'); // Mostrar el calendario de disponibilidad
                updateWeekRange(); // Mostrar el rango de la semana después de seleccionar un dentista
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los horarios:', error);
            }
        });

        // Marcar el dentista seleccionado
        $('.dentista-card').removeClass('bg-blue-100 border-blue-500');
        $(this).addClass('bg-blue-100 border-blue-500');
    });

    // Manejar clic en el botón "Todos los horarios"
    $('#all-times').click(function() {
        fetchHorariosDisponibles();
        // Marcar el botón seleccionado
        $('.time-button').removeClass('selected-button');
        $(this).addClass('selected-button');
    });

    // Manejar clic en el botón "Mañana"
    $('#morning-times').click(function() {
        fetchHorariosDisponibles('morning');
        // Marcar el botón seleccionado
        $('.time-button').removeClass('selected-button');
        $(this).addClass('selected-button');
    });

    // Manejar clic en el botón "Tarde"
    $('#afternoon-times').click(function() {
        fetchHorariosDisponibles('afternoon');
        // Marcar el botón seleccionado
        $('.time-button').removeClass('selected-button');
        $(this).addClass('selected-button');
    });

    function fetchHorariosDisponibles(timeOfDay) {
        const dentistaId = $('#user_id').val(); // Obtener el ID del dentista seleccionado
        const selectedDate = $('#fecha').val(); // Obtener la fecha seleccionada

        if (dentistaId && selectedDate) {
            // Hacer una solicitud AJAX al backend para obtener los horarios disponibles del dentista
            $.ajax({
                url: '/get-horarios-disponibles',
                method: 'GET',
                data: {
                    dentista_id: dentistaId,
                    fecha: selectedDate
                },
                success: function(response) {
                    let horarios = response.horarios;

                    // Filtrar los horarios según el momento del día
                    if (timeOfDay === 'morning') {
                        // Filtrar los horarios de la mañana (antes de las 12:00)
                        horarios = horarios.filter(horario => {
                            const hour = parseInt(horario.split(':')[0]);
                            return hour < 12;
                        });
                    } else if (timeOfDay === 'afternoon') {
                        // Filtrar los horarios de la tarde (después de las 12:00)
                        horarios = horarios.filter(horario => {
                            const hour = parseInt(horario.split(':')[0]);
                            return hour >= 12;
                        });
                    }
                    
                    // Actualizar el DOM con los horarios del dentista
                    updateTimeSlots(horarios);
                    // Verificar si no hay horarios disponibles
                    if (horarios.length <= 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin horas disponibles',
                            text: 'El dentista seleccionado no tiene horas disponibles para este día.',
                            confirmButtonText: 'Cerrar'
                        });
                        return; // Salir de la función si no hay horarios disponibles
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los horarios:', error);
                }
            });
        } else {
            alert('Por favor, seleccione un dentista.');
        }
    }

    function updateCalendar(data) {
        // Actualizar los horarios
        const timeSlotsContainer = $('#time-slots');
        timeSlotsContainer.empty();
        data.horarios.forEach(horario => {
            const timeSlotElement = `<button type="button" class="bg-gray-50 hover:bg-gray-100 p-3 rounded-lg text-center time-slot">
                                ${horario}
                            </button>`;
            timeSlotsContainer.append(timeSlotElement);
        });

        // Manejar clic en un botón de horario
        $('.time-slot').click(function() {
            // Marcar el botón seleccionado
            $('.time-slot').removeClass('bg-blue-500 text-white selected');
            $(this).addClass('bg-blue-500 text-white selected');

            // Guardar la hora seleccionada en el campo oculto
            horaInput.value = $(this).text();
        });

    }

    function updateTimeSlots(horarios) {
        const timeSlotsContainer = $('#time-slots');
        timeSlotsContainer.empty();
        horarios.forEach(horario => {
            const timeSlotElement = `<button type="button" class="bg-gray-50 hover:bg-gray-100 p-3 rounded-lg text-center time-slot">
                                ${horario}
                            </button>`;
            timeSlotsContainer.append(timeSlotElement);
        });

        // Manejar clic en un botón de horario
        $('.time-slot').click(function() {
            // Deseleccionar cualquier bloque previamente seleccionado
            $('.time-slot').removeClass('bg-blue-500 text-white selected');

            // Seleccionar el nuevo bloque
            $(this).addClass('bg-blue-500 text-white selected');

            // Guardar la hora seleccionada en el campo oculto
            const selectedTime = $(this).text();
            horaInput.value = selectedTime;
        });
    }


    $(document).ready(function() {
        const origenSelect = document.getElementById('origen');
        const motivoInput = document.getElementById('motivo');

        // Función para habilitar o deshabilitar el campo motivo
        function toggleMotivo() {
            if (origenSelect.value === 'Urgencia' || origenSelect.value === 'Consulta') {
                motivoInput.disabled = false;
                motivoInput.required = true;
            } else {
                motivoInput.disabled = true;
                motivoInput.required = false;
                motivoInput.value = ''; // Limpiar el valor del campo motivo
            }
        }

        // Llamar a la función al cargar la página
        toggleMotivo();

        // Llamar a la función cada vez que cambie el valor del campo origen
        origenSelect.addEventListener('change', toggleMotivo);
    });

    //observaciones y Motivo 
    document.addEventListener('DOMContentLoaded', function() {
        const motivoInput = document.getElementById('motivo');
        const motivoError = document.getElementById('motivo_error');

        motivoInput.addEventListener('input', function() {
            if (motivoInput.value.length < 2) {
                motivoError.style.display = 'block';
                motivoInput.classList.add('is-invalid');
            } else {
                motivoError.style.display = 'none';
                motivoInput.classList.remove('is-invalid');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const observacionesInput = document.getElementById('observaciones');
        const observacionesError = document.getElementById('observaciones_error');

        observacionesInput.addEventListener('input', function() {
            if (observacionesInput.value.length < 2) {
                observacionesError.style.display = 'block';
                observacionesInput.classList.add('is-invalid');
            } else {
                observacionesError.style.display = 'none';
                observacionesInput.classList.remove('is-invalid');
            }
        });
    });

    // JavaScript para manejar la navegación entre pasos y la barra de progreso
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
            // Validar que se haya seleccionado una hora
            const horaError = document.getElementById('hora-error');
            if (currentStep === 0 && !horaInput.value) {
                horaError.classList.remove('hidden');
                horaInput.classList.add('is-invalid');
                valid = false;
            } else {
                horaError.classList.add('hidden');
                horaInput.classList.remove('is-invalid');
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

    };
</script>
<style>
    .selected-button {
        background-color: #4299e1;
        /* Azul */
        color: white;
    }
</style>
@endsection