@extends('adminlte::page')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ __('Listado de Horarios') }}</span>
            <a href="{{ route('horarios_laborales.create')}}" class="btn btn-success btn-sm">Crear Horario</a>
        </div>
        <div class="card-body">
            <table id="horariosTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Día de la Semana</th>
                        <th>Mes</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horarios as $horario)
                    <tr>
                        <td>{{ $horario->user->name . ' ' . $horario->user->apellido_p }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->start_datetime)->translatedFormat('l') . ' ' . \Carbon\Carbon::parse($horario->start_datetime)->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->start_datetime)->translatedFormat('F') }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->start_datetime)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->end_datetime)->format('H:i') }}</td>
                        <td>
                            <div class="user-item">
                                <a href="{{ route('horarios_laborales.edit', ['id' => $horario->id, 'modo' => 'ver']) }}" class="btn btn-info">Ver</a>

                                <a href="{{ route('horarios_laborales.edit', ['id' => $horario->id, 'modo' => 'editar']) }}" class="btn btn-warning">Editar</a>

                                <form action="{{ route('horarios_laborales.destroy', $horario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <!-- Enlace al calendario -->
            <a href="{{ route('horarios_laborales.calendar') }}" class="btn btn-secondary">Ver Calendario</a>
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
