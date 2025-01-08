@extends('adminlte::page')

@section('title', 'Crear Presupuesto')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')

    <!-- Tarjeta para la información del presupuesto -->
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Información del Presupuesto') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('presupuestos.store') }}" method="POST">
                @csrf
                <!-- Campo de entrada para buscar el RUT del paciente -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-black">
                    <!-- RUT del Paciente -->
                    <div class="form-group">
                        <label for="rut_paciente" class="text-gray-700 font-medium">{{ __('RUT del Paciente') }}</label>
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

                    <!-- Nombre del Paciente -->
                    <div class="form-group">
                        <label for="nombre_paciente" class="text-gray-700 font-medium">{{ __('Nombre del Paciente') }}</label>
                        <input id="nombre_paciente" type="text" class="form-control" name="nombre_paciente" readonly>
                    </div>

                    <!-- Fecha -->
                    <div class="form-group">
                        <label for="fecha" class="text-gray-700 font-medium">{{ __('Fecha') }}</label>
                        <input id="fecha" type="datetime-local" class="form-control @error('fecha') is-invalid @enderror" name="fecha" required />
                        @error('fecha')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Campo oculto para el subtotal, descuento, saldo_pendiente, total_final  -->
                <input type="hidden" name="subtotal" value="0">
                <input type="hidden" name="descuento" value="0">
                <input type="hidden" name="saldo_pendiente" value="0">
                <input type="hidden" name="total_final" value="0">
        </div>
        <div class="text-center my-3">
            <button type="submit" class="btn btn-primary">Crear Presupuesto</button>
        </div>
        </form>
    </div>
</div>
<div class="container mx-auto p-4">
    <!-- Tarjeta para los detalles del presupuesto -->
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Detalles del Presupuesto') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('detalles.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Id Presupuesto -->
                    <div class="form-group">
                        <label for="presupuesto_id" class="text-gray-700 font-medium">{{ __('Id Presupuesto') }}</label>
                        <input type="text" id="presupuesto_id" name="presupuesto_id" class="form-control @error('presupuesto_id') is-invalid @enderror" value="{{ request()->query('presupuesto_id') }}" readonly />
                        <div id="presupuesto-error" class="invalid-feedback" style="display: none;">
                            <strong>Por favor, cree un presupuesto antes de agregar un detalle.</strong>
                        </div>
                        @error('presupuesto_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Pieza -->
                    <div class="form-group">
                        <label for="pieza" class="text-gray-700 font-medium">{{ __('Pieza') }}</label>
                        <input id="pieza" type="text" class="form-control @error('pieza') is-invalid @enderror" name="pieza" required />
                        @error('pieza')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Tratamiento -->
                    <div class="form-group">
                        <label for="tratamiento" class="text-gray-700 font-medium">{{ __('Tratamiento') }}</label>
                        <input id="tratamiento" type="text" class="form-control @error('tratamiento') is-invalid @enderror" name="tratamiento" required />
                        @error('tratamiento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Campo oculto para Estado Tratamiento -->
                    <input type="hidden" id="tratamiento_estado" name="tratamiento_estado" value="Pendiente">

                    <!-- Observaciones -->
                    <div class="form-group">
                        <label for="observaciones" class="text-gray-700 font-medium">{{ __('Observaciones') }}</label>
                        <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3" placeholder="Observaciones"></textarea>
                        @error('observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div class="form-group">
                        <label for="precio" class="text-gray-700 font-medium">{{ __('Precio') }}</label>
                        <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" min="0" required placeholder="$ Precio" />
                        @error('precio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Botón para guardar detalles -->
                <div class="text-center my-3">
                    <button type="button" id="agregar-detalle" class="btn btn-primary">Agregar Detalle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('fecha');
        if (fechaInput) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            fechaInput.value = formattedDateTime;
        }
    });
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
    document.getElementById('agregar-detalle').addEventListener('click', function() {
        const presupuestoIdInput = document.getElementById('presupuesto_id');
        const presupuestoError = document.getElementById('presupuesto-error');

        if (!presupuestoIdInput.value) {
            presupuestoIdInput.classList.add('is-invalid');
            presupuestoError.style.display = 'block';
            presupuestoIdInput.focus();
            return;
        } else {
            presupuestoIdInput.classList.remove('is-invalid');
            presupuestoError.style.display = 'none';
        }

        // Si el campo está completado, permitir el envío del formulario
        const form = presupuestoIdInput.closest('form');
        if (form.checkValidity()) {
            form.submit();
        } else {
            form.reportValidity();
        }
    });
</script>
@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#detallesTable').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ total registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
@endsection
@endsection