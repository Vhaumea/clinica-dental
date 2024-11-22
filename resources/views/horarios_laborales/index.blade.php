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



            <table class="table">
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
                        <td>{{ \Carbon\Carbon::parse($horario->start_datetime)->translatedFormat('l') . ' ' . \Carbon\Carbon::parse($horario->start_datetime)->day }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($horario->start_datetime)->translatedFormat('F') }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->start_datetime)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->end_datetime)->format('H:i') }}</td>
                        <td>
                            <div class="user-item">
                                <a href="{{ route('horarios_laborales.edit', ['id' => $horario->id, 'modo' => 'ver']) }}"
                                    class="btn btn-info">Ver</a>

                                <a href="{{ route('horarios_laborales.edit', ['id' => $horario->id, 'modo' => 'editar']) }}"
                                    class="btn btn-warning">Editar</a>

                                <form action="{{ route('horarios_laborales.destroy', $horario->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Borrar</button>
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
@endsection