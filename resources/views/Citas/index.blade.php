@extends('adminlte::page')

@section('title', 'Listado de Horas')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4 d-flex justify-content-center align-items-center">
            <h2 class="text-lg font-semibold">{{ __('Citas') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <div class="overflow-x-auto">
                <table id="citasTable" class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">ID Cita</th>
                            <th class="py-3 px-6 text-left">Nombre del Paciente</th>
                            <th class="py-3 px-6 text-left">Nombre del Dentista</th>
                            <th class="py-3 px-6 text-left">Presupuesto</th>
                            <th class="py-3 px-6 text-left">Día, Fecha y Hora de la Cita</th>
                            <th class="py-3 px-6 text-left">Estado</th>
                            <th class="py-3 px-6 text-left">Medio</th>
                            <th class="py-3 px-6 text-left">Creado el</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($citas as $cita)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $cita->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $cita->paciente->nombre . ' ' . $cita->paciente->apellido_p }}</td>
                            <td class="py-3 px-6 text-left">{{ $cita->user->name . ' ' . $cita->user->apellido_p }}</td>
                            <td class="py-3 px-6 text-left">{{ $cita->presupuesto ? $cita->presupuesto->id : 'Sin presupuesto' }}</td>
                            <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($cita->fecha)->locale('es')->isoFormat('dddd, D MMMM YYYY') . ' ' . $cita->hora }}</td>
                            <td class="py-3 px-6 text-left">{{ $cita->estado }}</td>
                            <td class="py-3 px-6 text-left">{{ $cita->medio }}</td>
                            <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($cita->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('citas.edit', ['cita' => $cita->id, 'modo' => 'ver']) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">Ver</a>
                                    <a href="{{ route('citas.edit', ['cita' => $cita->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">Editar</a>
                                    <a href="{{ route('citas.create', ['paciente_id' => $cita->paciente->id, 'presupuesto_id' => $cita->presupuesto_id]) }}" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-green-600">Crear Cita</a>
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
        $('#citasTable').DataTable({
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