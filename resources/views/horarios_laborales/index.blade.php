
@extends('adminlte::page')

@section('title', 'Horarios Laborales')
@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ __('Listado de Horarios') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <div class="overflow-x-auto">
                <table id="horariosTable" class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">Usuario</th>
                            <th class="py-3 px-6 text-left">Día de la Semana</th>
                            <th class="py-3 px-6 text-left">Mes</th>
                            <th class="py-3 px-6 text-left">Hora de Inicio</th>
                            <th class="py-3 px-6 text-left">Hora de Fin</th>
                            <th class="py-3 px-6 text-left">Estado</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($horarios as $horario)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $horario->user->name . ' ' . $horario->user->apellido_p }}</td>
                            <td class="py-3 px-6 text-left">{{ ucfirst(\Carbon\Carbon::parse($horario->start_datetime)->locale('es')->isoFormat('dddd D')) }}</td>
                            <td class="py-3 px-6 text-left">{{ ucfirst(\Carbon\Carbon::parse($horario->start_datetime)->locale('es')->isoFormat('MMMM')) }}</td>
                            <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($horario->start_datetime)->format('H:i') }}</td>
                            <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($horario->end_datetime)->format('H:i') }}</td>
                            <td class="py-3 px-6 text-center">{{ $horario->estado }}</td>

                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('horarios_laborales.edit', ['id' => $horario->id, 'modo' => 'ver']) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">Ver</a>
                                    @if(Auth::check() && Auth::user()->isAdmin())
                                    <a href="{{ route('horarios_laborales.edit', ['id' => $horario->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">Editar</a>
                                    <form action="{{ route('horarios_laborales.toggleStatus', $horario->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="py-2 px-4 rounded-md shadow-sm {{ $horario->estado === 'Activo' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                            {{ $horario->estado === 'Activo' ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            <a href="{{ route('horarios_laborales.calendar') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">Ver Calendario</a>
        </div>
    </div>
</div>

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#horariosTable').DataTable({
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