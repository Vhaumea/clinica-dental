@extends('adminlte::page')

@section('title', 'Usuarios')
@section('content')
    <div class="container">
        @include('includes.message')
        <div class="card">
            <div class="card-header">{{ __('Listado de usuarios') }}</div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Rol</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->role }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->apellido_p }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <div class="user-item">
                                        <a href="{{ route('users.configuracion', ['id' => $usuario->id, 'modo' => 'ver']) }}"
                                            class="btn btn-info">Ver</a>

                                        <a href="{{ route('users.configuracion', ['id' => $usuario->id, 'modo' => 'editar']) }}"
                                            class="btn btn-warning">Editar</a>

                                        <form action="{{ route('users.destroy', $usuario->id) }}" method="POST"
                                            style="display:inline;">
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
            </div>
        </div>
    </div>

@endsection
