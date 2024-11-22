@extends('adminlte::page')

@section('title', 'Crear Presupuesto')

@section('content')
<div class="container">
    @include('includes.message')

    <!-- Tarjeta para la información del presupuesto -->
    <div class="card mb-4">
        <div class="card-header">{{ __('Información del Presupuesto') }}</div>
        <div class="card-body">
            <form action="{{ route('presupuestos.store') }}" method="POST">
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

                <!-- Campo oculto para el subtotal, descuento, saldo_pendiente, total_final  -->
                <input type="hidden" name="subtotal" value="0">
                <input type="hidden" name="descuento" value="0">
                <input type="hidden" name="saldo_pendiente" value="0">
                <input type="hidden" name="total_final" value="0">
                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary">Crear Presupuesto</button>
                </div>

            </form>

            <div class="card mb-4">
                <div class="card-header">{{ __('Listado de Presupuestos') }}</div>
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Id Presupuesto</th>
                            <th>Paciente</th>
                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Saldo Pendiente</th>
                            <th>Total Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $presupuesto)
                        <tr>
                            <td>
                                <a href="#" onclick="selectPresupuesto({{ $presupuesto->id }})">{{ $presupuesto->id }}</a>
                            </td>
                            <td>{{ $presupuesto->paciente->nombre}} {{ $presupuesto->paciente->apellido_p}} {{ $presupuesto->paciente->apellido_m}}</td>
                            <td>{{ $presupuesto->subtotal }}</td>
                            <td>{{ $presupuesto->descuento }}</td>
                            <td>{{ $presupuesto->saldo_pendiente }}</td>
                            <td>{{ $presupuesto->total_final }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                


            </div>
        </div>
    </div>

    <!-- Tarjeta para los detalles del presupuesto -->
    <div class="card">
        <div class="card-header">{{ __('Detalles del Presupuesto') }}</div>
        <div class="card-body">
            <div class="card mb-4">
                <div class="card-header">{{ __('Listado de Detalles del Presupuesto') }}</div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Id Presupuesto</th>
                            <th>Pieza</th>
                            <th>Tratamiento</th>
                            <th>Observaciones</th>
                            <th>Precio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->presupuesto_id }}</td>
                            <td>{{ $detalle->pieza }}</td>
                            <td>{{ $detalle->tratamiento }}</td>
                            <td>{{ $detalle->observaciones }}</td>
                            <td>$ {{ $detalle->precio }} </td>
                            <td>{{ $detalle->tratamiento_estado }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            <!-- Contenedor para los detalles -->
            <form action="{{ route('detalles.store') }}" method="POST">
                @csrf
                <table id='tablaDetalles' class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Id Presupuesto</th>
                            <th>Pieza</th>
                            <th>Tratamiento</th>
                            <th>Observaciones</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody id='cuerpoTablaDetallesDetalles'>
                        <!-- Aquí se agregarán los detalles -->
                        <tr>
                            <td>
                                <input type="text" id="presupuesto_id" name="presupuesto_id" class="form-control @error('presupuesto_id') is-invalid @enderror" value="{{ $lastPresupuesto ? $lastPresupuesto->id : '' }}" readonly style="width: 90px;" />
                                @error('presupuesto_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            <td>
                                <input id="pieza" type="text" class="form-control @error('pieza') is-invalid @enderror" name="pieza" required style="width: 90px;" />
                                @error('pieza')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>

                            <td>
                                <input id="tratamiento" type="text" class="form-control @error('tratamiento') is-invalid @enderror" name="tratamiento" required style="width: 300px;" />
                                @error('tratamiento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            <td>
                                <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3" style="width: 400px;" placeholder="Observaciones"></textarea>
                                @error('observaciones')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            <td>
                                <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" min="0" required style="width: 100px;" placeholder="$ Precio" /> 
                                @error('precio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center my-3">
                    <!-- Botón para guardar detalles -->
                    <button type="submit" class="btn btn-primary">Agregar Detalle</button>
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

    // funcion para el detalle
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

    function selectPresupuesto(id) {
        document.getElementById('presupuesto_id').value = id; // Actualiza el campo de entrada con el ID seleccionado
    }
    document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.getElementById('add-detalle');

        addButton.addEventListener('click', function() {
            // Obtener datos del formulario
            const precio = document.getElementById('precio').value;
            const presupuestoId = document.getElementById('presupuesto_id').value;

            // Enviar datos al servidor usando fetch API
            fetch('{{ route("detalles.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        precio: precio,
                        presupuesto_id: presupuestoId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar la tabla del presupuesto con los nuevos detalles
                        fetchDetalles(presupuestoId); // Función para actualizar los detalles y totales
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function fetchDetalles(presupuestoId) {
        fetch(`{{ url('/detalles-presupuesto') }}/${presupuestoId}`)
            .then(response => response.json())
            .then(detalles => {
                // Aquí actualizas la tabla con los nuevos detalles y recalculas el total
            });
    }
</script>
<style>
    .pagination {
        justify-content: center;
        /* Centra la paginación */
    }

    .pagination .page-item {
        margin: 0 2px;
        /* Espaciado entre los elementos */
    }

    .pagination .page-link {
        border-radius: 5px;
        /* Bordes redondeados */
        padding: 5px 8px;
        /* Espaciado interno más pequeño */
        font-size: 0.85rem;
        /* Tamaño de fuente más pequeño */
        line-height: 1.2;
        /* Ajusta la altura de línea */
    }

    .pagination .page-link:hover {
        background-color: #007bff;
        /* Color al pasar el mouse */
        color: white;
        /* Color del texto al pasar el mouse */
    }

    .pagination .active .page-link {
        background-color: #007bff;
        /* Color del fondo para el elemento activo */
        color: white;
        /* Color del texto para el elemento activo */
    }

    .pagination .disabled .page-link {
        color: #6c757d;
        /* Color para enlaces deshabilitados */
    }
</style>
@endsection