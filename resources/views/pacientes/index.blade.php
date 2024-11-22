@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Listado de pacientes') }}</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos p</th>
                        <th>Apellidos m</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->id }}</td>
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->apellido_p }}</td>
                        <td>{{ $paciente->apellido_m }}</td>
                        <td>{{ $paciente->email }}</td>
                        <td>
                            <div class="user-item">
                                <a href="{{ route('pacientes.edit', ['id' => $paciente->id, 'modo' => 'ver']) }}"
                                    class="btn btn-info">Ver</a>

                                <a href="{{ route('pacientes.edit', ['id' => $paciente->id, 'modo' => 'editar']) }}"
                                    class="btn btn-warning">Editar</a>

                                <form action="{{ route('pacientes.destroy', $paciente->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este paciente?');">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

