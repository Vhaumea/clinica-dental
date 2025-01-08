@extends('adminlte::page')

@section('title', 'Editar Cita')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Editar Cita') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form id="cita-form" action="{{ route('citas.update', $cita->id) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="grid grid-cols-1 gap-4 mb-4 text-black">
                    <div id="step1" class="step">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información del Paciente') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                            <!-- Rut del Paciente -->
                            <div class="form-group">
                                <label for="rut_paciente" class="text-gray-700 font-medium">{{ __('Rut Paciente') }}</label>
                                <input type="text" id="rut_paciente" name="rut_paciente"
                                    value="{{ $cita->paciente->rut}}"
                                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 @error('rut_paciente') border-red-500 @enderror" readonly />
                                @error('rut_paciente')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Nombre Completo del Paciente -->
                            <div class="form-group">
                                <label for="nombre_completo_paciente" class="text-gray-700 font-medium">{{ __('Nombre del Paciente') }}</label>
                                <input type="text" id="nombre_completo_paciente" name="nombre_completo_paciente"
                                    value="{{ $cita->paciente->nombre . ' ' . $cita->paciente->apellido_p  . ' ' . $cita->paciente->apellido_m }}"
                                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 @error('nombre_completo_paciente') border-red-500 @enderror" readonly />
                                @error('nombre_completo_paciente')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Presupuesto -->
                            <div class="form-group">
                                <label for="presupuesto_id" class="text-gray-700 font-medium">{{ __('Presupuesto') }}</label>
                                <input type="text" id="presupuesto_display" name="presupuesto_display"
                                    value="{{ $cita->presupuesto ? 'ID: ' . $cita->presupuesto->id . ' - ' . $cita->presupuesto->estado . ' - ' . $cita->presupuesto->fecha : 'Sin presupuesto' }}"
                                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 @error('presupuesto_id') border-red-500 @enderror" readonly />
                                <input type="hidden" id="presupuesto_id" name="presupuesto_id" value="{{ $cita->presupuesto ? $cita->presupuesto->id : '' }}">
                                @error('presupuesto_id')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                            <!-- Medio -->
                            <div class="form-group">
                                <label for="medio" class="text-gray-700 font-medium">{{ __('Medio de agendación') }}</label>
                                <select id="medio" name="medio" class="w-full px-4 py-2 border rounded-lg bg-white @error('medio') border-red-500 @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                                    <option value="Facebook" {{ $cita->medio === 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                    <option value="Whatsapp" {{ $cita->medio === 'Whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="Presencial" {{ $cita->medio === 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="Teléfono" {{ $cita->medio === 'Teléfono' ? 'selected' : '' }}>Teléfono</option>
                                </select>
                                @error('medio')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="step2" class="step">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información de la Cita') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                            <!-- Nombre del Dentista -->
                            <div class="form-group">
                                <label for="user_nombre" class="text-gray-700 font-medium">{{ __('Nombre de Dentista') }}</label>
                                <input type="text" id="user_nombre" class="w-full px-4 py-2 border rounded-lg bg-gray-100" name="user_nombre" value="{{$cita->user->name . ' ' . $cita->user->apellido_p }}" readonly required>
                            </div>

                            <!-- Fecha y hora -->
                            <div class="form-group">
                                <label for="fecha_hora" class="text-gray-700 font-medium">{{ __('Fecha y hora') }}</label>
                                <input type="datetime-local" id="fecha_hora" class="w-full px-4 py-2 border rounded-lg bg-gray-100" name="fecha_hora" value="{{ $cita->fecha . 'T' . $cita->hora}}" readonly required>
                            </div>

                            <!-- Origen -->
                            <div class="form-group">
                                <label for="origen" class="text-gray-700 font-medium">{{ __('Origen') }}</label>
                                <input id="origen" type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100 @error('origen') border-red-500 @enderror" name="origen" value="{{ old('origen', $cita->origen) }}" readonly />
                                @error('origen')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                            <!-- Motivo -->
                            <div class="form-group">
                                <label for="motivo" class="text-gray-700 font-medium">{{ __('Motivo') }}</label>
                                <input id="motivo" type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100 @error('motivo') border-red-500 @enderror" name="motivo" value="{{ $cita->motivo }}" maxlength="255" readonly />
                                @error('motivo')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Observaciones -->
                            <div class="form-group">
                                <label for="observaciones" class="text-gray-700 font-medium">{{ __('Observaciones') }}</label>
                                <textarea id="observaciones" class="w-full px-4 py-2 border rounded-lg @error('observaciones') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-100' : '' }}" name="observaciones" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }}>{{ old('observaciones', $cita->observaciones) }}</textarea>
                                @error('observaciones')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo de estado -->
                            <div class="form-group">
                                <label for="estado" class="text-gray-700 font-medium">{{ __('Estado') }}</label>
                                <select name="estado" id="estado"
                                    class="w-full px-4 py-2 border rounded-lg @error('estado') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-100' : 'bg-white' }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                                    <option value="Pendiente" {{ old('estado', $cita->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Confirmada" {{ old('estado', $cita->estado) == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                    <option value="Cancelada" {{ old('estado', $cita->estado) == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    <option value="Completada" {{ old('estado', $cita->estado) == 'Completada' ? 'selected' : '' }}>Completada</option>
                                    <option value="No asistio" {{ old('estado', $cita->estado) == 'No asistio' ? 'selected' : '' }}>No asistió</option>
                                </select>
                                @error('estado')
                                <span class="text-red-500 text-sm mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- Botón para enviar el formulario -->
                    @if (isset($modo) && $modo !== 'ver')
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">{{ __('Actualizar Cita') }}</button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Formulario de Notas de Evolución -->
    @if ($cita->estado == 'Completada' && (!isset($modo) || $modo !== 'ver'))
    <div id="notas-evolucion-container" class="card shadow-lg rounded-lg overflow-hidden mt-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Crear Nota de Evolución') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('notas_evolucion.store') }}" method="POST">
                @csrf

                <!-- Campo de Cita ID -->
                <div class="row mb-3">
                    <label for="cita_id" class="col-md-4 col-form-label text-md-end">{{ __('ID de la Cita') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="cita_id" name="cita_id" class="form-control @error('cita_id') is-invalid @enderror" value="{{ $cita->id }}" readonly>
                        @error('cita_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Campo de Descripción -->
                <div class="row mb-3">
                    <label for="descripcion" class="col-md-4 col-form-label text-md-end">{{ __('Descripción') }}</label>
                    <div class="col-md-6">
                        <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Campo de Fecha Nota -->
                <div class="row mb-3">
                    <label for="fecha_nota" class="col-md-4 col-form-label text-md-end">{{ __('Fecha y Hora de la Nota') }}</label>
                    <div class="col-md-6">
                        <input type="datetime-local" id="fecha_nota" name="fecha_nota" class="form-control @error('fecha_nota') is-invalid @enderror" value="{{ old('fecha_nota') }}">
                        @error('fecha_nota')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Campo de Observaciones -->
                <div class="row mb-3">
                    <label for="observaciones_evolucion" class="col-md-4 col-form-label text-md-end">{{ __('Observaciones') }}</label>
                    <div class="col-md-6">
                        <textarea id="observaciones_evolucion" class="form-control @error('observaciones_evolucion') is-invalid @enderror" name="observaciones_evolucion">{{ old('observaciones_evolucion') }}</textarea>
                        @error('observaciones_evolucion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Campo oculto para Estado Nota -->
                <input type="hidden" name="estado_nota" value="Activo">

                <!-- Botón para enviar el formulario -->
                <div class="flex justify-end mt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">{{ __('Crear Nota de Evolución') }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Contenedor para la lista de Notas de Evolución -->
    <div class="card shadow-lg rounded-lg overflow-hidden mt-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Notas de Evolución') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <div class="table-responsive">
                <table id="notasTable" class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('N° Nota evolucion') }}</th>
                            <th>{{ __('Descripción') }}</th>
                            <th>{{ __('Observaciones') }}</th>
                            <th>{{ __('Fecha y Hora') }}</th>
                            <th>{{ __('Estado') }}</th>
                            @if (!isset($modo) || $modo !== 'ver')
                            <th>{{ __('Acciones') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notasEvolucion as $nota)
                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->descripcion }}</td>
                            <td>{{ $nota->observaciones_evolucion }}</td>
                            <td>{{ $nota->fecha_nota }}</td>
                            <td>{{ $nota->estado_nota }}</td>
                            @if (!isset($modo) || $modo !== 'ver')
                            <td>
    <a href="{{ route('notas_evolucion.edit', $nota->id) }}" class="btn btn-primary btn-sm">{{ __('Editar') }}</a>
    <form action="{{ route('notas_evolucion.toggleStatus', $nota->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $nota->estado_nota === 'Activo' ? 'btn-danger' : 'btn-success' }}">
    {{ $nota->estado_nota === 'Activo' ? __('Desactivar') : __('Activar') }}
</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones para cambiar entre modos -->
    <div class="d-flex justify-content-between mt-3">
        <!-- Enlace para volver a la lista (a la izquierda) -->
        <a href="{{ route('citas.index') }}" class="btn btn-secondary">{{ __('Volver a la lista') }}</a>

        <div class="d-flex">
            @if (isset($modo) && $modo === 'ver')
            <a href="{{ route('citas.edit', ['cita' => $cita->id, 'modo' => 'editar']) }}"
                class="btn btn-warning ml-2">Editar</a>
            @else
            <a href="{{ route('citas.edit', ['cita' => $cita->id, 'modo' => 'ver']) }}"
                class="btn btn-secondary ml-2">Ver</a>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estadoSelect = document.getElementById('estado');
        const notasEvolucionContainer = document.getElementById('notas-evolucion-container');
        const citaForm = document.getElementById('cita-form');

        function toggleNotasEvolucion() {
            if (estadoSelect.value === 'Completada') {
                notasEvolucionContainer.style.display = 'block';
            } else {
                notasEvolucionContainer.style.display = 'none';
            }
        }

        // Llamar a la función al cargar la página
        toggleNotasEvolucion();

        // Llamar a la función cada vez que cambie el valor del campo estado
        estadoSelect.addEventListener('change', toggleNotasEvolucion);

        // Habilitar el campo estado antes de enviar el formulario si está deshabilitado
        citaForm.addEventListener('submit', function() {
            if (estadoSelect.disabled) {
                estadoSelect.disabled = false;
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const fechaNotaInput = document.getElementById('fecha_nota');
        if (fechaNotaInput) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            fechaNotaInput.value = formattedDateTime;
        }
    });
    $(document).ready(function() {
        $('#notasTable').DataTable({
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