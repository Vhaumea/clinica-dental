@extends('adminlte::page')

@section('title', 'Crear Presupuesto')

@section('content')
<div class="container">
    @include('includes.message') <!-- Mensajes de éxito o error -->

    <!-- Tarjeta para la información del presupuesto -->
    <div class="card mb-4">
        <div class="card-header">{{ __('Información del Presupuesto') }}</div>
        <div class="card-body">
            <form action="{{ route('presupuestos.store') }}" method="POST">
                @csrf

                <div class="presupuesto-container">
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

                    <!-- Fila para tabla de detalles y resumen -->
                    <div class="row">
                        <!-- Tabla de detalles -->
                        <div class="col-md-8">
                            <table id="tablaDetalles" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>N° Detalle</th>
                                        <th>Pieza</th>
                                        <th>Tratamiento</th>
                                        <th>Estado</th>
                                        <th>Precio</th>
                                        <th>Observaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaDetalles"></tbody>
                            </table>
                        </div>

                        <!-- Resumen del presupuesto en un cuadro a la derecha -->
                        <div class="col-md-4">
                            <div class="card presupuesto-resumen">
                                <div class="card-header">{{ __('Resumen del Presupuesto') }}</div>
                                <div class="card-body">
                                    <p>Subtotal: <span id="subtotal">0</span></p>
                                    <p>Descuento: <span id="descuento">0</span></p>
                                    <p>Total Final: <span id="totalFinal">0</span></p>
                                    <!-- Botón para guardar el presupuesto, colocado debajo de la tabla -->
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Guardar Presupuesto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <!-- Tarjeta para los detalles del presupuesto -->
    <div class="card">
        <div class="card-header">{{ __('Detalles del Presupuesto') }}</div>
        <div class="card-body">
            <!-- Contenedor para los detalles -->
            <form action="{{ route('detalles-presupuesto.store') }}" method="POST" id="detalles-form">
                @csrf
                <div id="detalles-container">
                    <table id="tablaDetalles" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="col-pieza-dental">Pieza</th>
                                <th>Tratamiento</th>
                                <th>Observaciones</th>
                                <th class="col-precio">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaDetalles">
                            <!-- Aquí se agregarán los detalles -->
                            <tr>
                                <td><input type="text" class="form-control pieza-id" name="pieza_id[]" placeholder="Pieza" /></td>
                                <td><input type="text" class="form-control tratamiento" name="tratamiento[]" placeholder="Tratamiento" /></td>
                                <td><input type="text" class="form-control observaciones" name="observaciones[]" placeholder="Observaciones" /></td>
                                <td><input type="number" class="form-control precio" name="precio[]" value="0" min="0" placeholder="Precio" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Botón para agregar detalles -->
                <div class="text-center mb-3">
                    <button type="button" id="add-detalle" class="btn btn-secondary">Agregar Detalle</button>
                </div>

            </form>

        </div>
    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.getElementById('add-detalle');
        const cuerpoTablaDetalles = document.getElementById('cuerpoTablaDetalles');

        addButton.addEventListener('click', function() {
            // Obtener datos del formulario de detalles
            const piezas = Array.from(document.querySelectorAll('.pieza-id')).map(input => input.value);
            const tratamientos = Array.from(document.querySelectorAll('.tratamiento')).map(input => input.value);
            const observaciones = Array.from(document.querySelectorAll('.observaciones')).map(input => input.value);
            const precios = Array.from(document.querySelectorAll('.precio')).map(input => input.value);

            // Enviar datos al servidor usando fetch API
            fetch('{{ route("detalles-presupuesto.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        pieza_id: piezas,
                        tratamiento: tratamientos,
                        observaciones: observaciones,
                        precio: precios,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar la tabla del presupuesto con los nuevos detalles
                        fetchDetalles();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        function fetchDetalles() {
            fetch('{{ route("detalles-presupuesto.index") }}')
                .then(response => response.json())
                .then(detalles => {
                    cuerpoTablaDetalles.innerHTML = ''; // Limpiar tabla actual

                    detalles.forEach((detalle, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${detalle.pieza_id}</td>
                        <td>${detalle.tratamiento}</td>
                        <td>Activo</td>
                        <td>${detalle.precio}</td>
                        <td>${detalle.observaciones || ''}</td>
                        <td><button type="button" class="btn btn-danger btn-sm eliminar-detalle" data-id="${detalle.id}">Eliminar</button></td>
                    `;
                        cuerpoTablaDetalles.appendChild(row);
                    });
                });
        }
    });
</script>
<style>
    .col-pieza-dental {
        width: 85px;
        /* Ajusta este valor según sea necesario */
    }

    .col-precio {
        width: 150px;
        /* Ajusta este valor según sea necesario */
    }
</style>
@endsection