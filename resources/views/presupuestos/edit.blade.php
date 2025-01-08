@extends('adminlte::page')

@section('title', 'Editar Presupuesto')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')

    <!-- Tarjeta para la información del presupuesto -->
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Información del Presupuesto') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Campo de entrada para buscar el RUT del paciente -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-black">
                    <div class="form-group">
                        <label for="rut_paciente" class="text-gray-700 font-medium">{{ __('RUT del Paciente') }}</label>
                        <input id="rut_paciente" type="text" class="form-control @error('rut_paciente') is-invalid @enderror" name="rut_paciente" value="{{ $presupuesto->paciente->rut }}" readonly>
                        @error('rut_paciente')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Campo para mostrar el nombre del paciente basado en el RUT seleccionado -->
                    <div class="form-group">
                        <label for="nombre_paciente" class="text-gray-700 font-medium">{{ __('Nombre del Paciente') }}</label>
                        <input id="nombre_paciente" type="text" class="form-control" name="nombre_paciente" value="{{ $presupuesto->paciente->nombre }} {{ $presupuesto->paciente->apellido_p }} {{ $presupuesto->paciente->apellido_m }}" readonly>
                    </div>

                    <!-- Campo para mostrar el subtotal -->
                    <div class="form-group">
                        <label for="subtotal" class="text-gray-700 font-medium">{{ __('Subtotal') }}</label>
                        <input id="subtotal" type="text" class="form-control" name="subtotal" value="{{ $presupuesto->subtotal }}" readonly>
                    </div>
                    
                    <!-- Campo para mostrar la fecha -->
                    <div class="form-group">
                        <label for="fecha" class="text-gray-700 font-medium">{{ __('Fecha') }}</label>
                        <input id="fecha" type="text" class="form-control" name="fecha" value="{{ $presupuesto->fecha }}" readonly>
                    </div>

                    <!-- Campo para editar el descuento -->
                    <div class="form-group">
                        <label for="descuento" class="text-gray-700 font-medium">{{ __('Descuento (%)') }}</label>
                        <input id="descuento" type="number" class="form-control @error('descuento') is-invalid @enderror" name="descuento" value="{{ $presupuesto->descuento }}" min="0" max="100" step="0.01" oninput="actualizarTotalFinal()" {{ $modo === 'ver' ? 'readonly' : '' }}>
                        @error('descuento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Campo para mostrar el total final -->
                    <div class="form-group">
                        <label for="total_final" class="text-gray-700 font-medium">{{ __('Total Final') }}</label>
                        <input id="total_final" type="text" class="form-control" name="total_final" value="{{ $presupuesto->total_final }}" readonly>
                    </div>

                    <!-- Campo para mostrar el saldo pendiente -->
                    <div class="form-group">
                        <label for="saldo_pendiente" class="text-gray-700 font-medium">{{ __('Saldo Pendiente') }}</label>
                        <input id="saldo_pendiente" type="text" class="form-control" name="saldo_pendiente" value="{{ $presupuesto->saldo_pendiente }}" readonly>
                    </div>

                    <!-- Campo para editar el estado del presupuesto -->
                    <div class="form-group">
                        <label for="estado" class="text-gray-700 font-medium">{{ __('Estado del Presupuesto') }}</label>
                        <select id="estado" class="form-control @error('estado') is-invalid @enderror" name="estado" {{ $modo === 'ver' ? 'disabled' : '' }}>
                            <option value="Pendiente" {{ $presupuesto->estado == 'Pendiente' ? 'selected' : '' }}>{{ __('Pendiente') }}</option>
                            <option value="En proceso" {{ $presupuesto->estado == 'En proceso' ? 'selected' : '' }}>{{ __('En proceso') }}</option>
                            <option value="Rechazado" {{ $presupuesto->estado == 'Rechazado' ? 'selected' : '' }}>{{ __('Rechazado') }}</option>
                            <option value="Completado" {{ $presupuesto->estado == 'Completado' ? 'selected' : '' }}>{{ __('Completado') }}</option>
                        </select>
                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @if($modo !== 'ver')
                <!-- Botón para actualizar el presupuesto -->
                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary">Actualizar Presupuesto</button>
                </div>
                @endif
            </form>
            @if($modo !== 'ver')
            <!-- Botón para crear un abono -->
            <div class="text-right my-3">
                <a href="{{ route('abonos.create', ['presupuesto_id' => $presupuesto->id]) }}" class="btn btn-success">Abonos</a>
            </div>
            @endif
        </div>
    </div>

    @if($modo !== 'ver')
    <!-- Tarjeta para agregar detalles del presupuesto -->
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __(' Agregar Detalles al Presupuesto') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('detalles.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Id Presupuesto -->
                    <div class="form-group">
                        <label for="presupuesto_id" class="text-gray-700 font-medium">{{ __('N° Presupuesto') }}</label>
                        <input type="text" id="presupuesto_id" name="presupuesto_id" class="form-control @error('presupuesto_id') is-invalid @enderror" value="{{ $presupuesto->id }}" readonly />
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

                    <input type="hidden" name="tratamiento_estado" value="Pendiente">

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
                <div class="text-center my-3">
                    <!-- Botón para guardar detalles -->
                    <button type="submit" class="btn btn-primary">Agregar Detalle</button>
                </div>
            </form>
        </div>
    </div>
    @endif
    <!-- Tarjeta para el listado de detalles del presupuesto -->
<div class="card shadow-lg rounded-lg overflow-hidden">
    <div class="card-header bg-white text-black text-center py-4">
        <h2 class="text-lg font-semibold">{{ __('Detalles del Presupuesto') }}</h2>
    </div>
    <div class="card-body p-6 bg-gray-100">
        <div class="overflow-x-auto">
            <table id="detallesTable" class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">N° Presupuesto</th>
                        <th class="py-3 px-6 text-left">Pieza</th>
                        <th class="py-3 px-6 text-left">Tratamiento</th>
                        <th class="py-3 px-6 text-left">Observaciones</th>
                        <th class="py-3 px-6 text-left">Precio</th>
                        <th class="py-3 px-6 text-left">Estado</th>
                        @if($modo !== 'ver')
                        <th class="py-3 px-6 text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($detalles as $detalle)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $detalle->presupuesto_id }}</td>
                        <td class="py-3 px-6 text-left">{{ $detalle->pieza }}</td>
                        <td class="py-3 px-6 text-left">{{ $detalle->tratamiento }}</td>
                        <td class="py-3 px-6 text-left">{{ $detalle->observaciones }}</td>
                        <td class="py-3 px-6 text-left">$ {{ $detalle->precio }} </td>
                        <td class="py-3 px-6 text-left">{{ $detalle->tratamiento_estado }}</td>
                        @if($modo !== 'ver')
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('detalles.edit', $detalle->id) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">Editar</a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>    <!-- Botones para cambiar entre modos -->
    <div class="flex justify-between mt-4">
        <!-- Enlace para volver a la lista -->

        <div class="flex space-x-2">
            @if (isset($modo) && $modo === 'ver')
            <a href="{{ route('presupuestos.edit', ['presupuesto' => $presupuesto->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">Editar</a>
            @else
            <a href="{{ route('presupuestos.edit', ['presupuesto' => $presupuesto->id, 'modo' => 'ver']) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">Ver</a>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

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

    function actualizarTotalFinal() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        const totalFinal = subtotal - (subtotal * (descuento / 100));
        document.getElementById('total_final').value = Math.round(totalFinal);
    }
</script>
@endsection