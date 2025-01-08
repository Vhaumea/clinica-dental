@extends('adminlte::page')

@section('title', 'Lista de Presupuestos')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4 d-flex justify-content-between align-items-center">
            <h2 class="text-lg font-semibold">{{ __('Listado de Presupuestos') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <div class="overflow-x-auto">
                <table id="presupuestosTable" class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Paciente</th>
                            <th class="py-3 px-6 text-left">Subtotal</th>
                            <th class="py-3 px-6 text-left">Descuento</th>
                            <th class="py-3 px-6 text-left">Total Final</th>
                            <th class="py-3 px-6 text-left">Saldo Pendiente</th>
                            <th class="py-3 px-6 text-left">Estado</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($presupuestos as $presupuesto)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $presupuesto->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $presupuesto->paciente->nombre }} {{ $presupuesto->paciente->apellido_p }} {{ $presupuesto->paciente->apellido_m }}</td>
                            <td class="py-3 px-6 text-left">$ {{ $presupuesto->subtotal }}</td>
                            <td class="py-3 px-6 text-left">{{ $presupuesto->descuento }} %</td>
                            <td class="py-3 px-6 text-left">$ {{ $presupuesto->total_final }}</td>
                            <td class="py-3 px-6 text-left">$ {{ $presupuesto->saldo_pendiente }}</td>
                            <td class="py-3 px-6 text-left">{{ $presupuesto->estado }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('presupuestos.edit', ['presupuesto' => $presupuesto->id, 'modo' => 'ver']) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">Ver</a>
                                    <a href="{{ route('presupuestos.edit', ['presupuesto' => $presupuesto->id, 'modo' => 'editar'])}}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">Editar</a>
                                    <a href="{{ route('citas.create', ['paciente_id' => $presupuesto->paciente->id, 'presupuesto_id' => $presupuesto->id]) }}" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-green-600 crear-cita-btn" data-estado="{{ $presupuesto->estado }}">Crear Cita</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#presupuestosTable').DataTable({
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

         // Interceptar el clic en el botón "Crear Cita"
         $('.crear-cita-btn').on('click', function(event) {
            var estado = $(this).data('estado');
            if (estado === 'Rechazado' || estado === 'Completado') {
                event.preventDefault();
                alert('No se puede crear una cita para un presupuesto en estado ' + estado + '.');
            }
        });
    });
</script>
@endsection
@endsection