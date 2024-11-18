@extends('adminlte::page')

@section('title', 'Lista de Citas')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ __('Citas') }}</h3>
            <a href="{{ route('citas.create') }}" class="btn btn-success btn-sm">Crear Cita</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Nombre del Paciente</th>
                        <th>Nombre del Dentista</th>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                    <tr>
                        <td>{{ $cita->id }}</td>
                        <td>{{ $cita->paciente->nombre . ' ' . $cita->paciente->apellido_p }}</td>
                        <td>{{ $cita->user->name . ' ' . $cita->user->apellido_p }}</td>
                        <td>{{ $cita->fecha . ' ' . $cita->hora}}</td>
                        <td>{{ $cita->estado }}</td>
                        <td>
                            <div class="user-item">
                                <a href="{{ route('citas.edit', ['id' => $cita->id, 'modo' => 'ver']) }}"
                                    class="btn btn-info">Ver</a>

                                <a href="{{ route('citas.edit', ['id' => $cita->id, 'modo' => 'editar']) }}"
                                    class="btn btn-warning">Editar</a>

                                <form action="{{ route('citas.destroy', $cita->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar la cita?');">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            {{ $citas->links() }}
        </div>
    </div>
</div>
@endsection