@extends('adminlte::page')

@section('title', 'Lista de Piezas Dentales')

@section('content')
    <div class="container">
        @include('includes.message')
        <div class="card">
            <div class="card-header">
                <h3>{{ __('Piezas Dentales') }}</h3>
                <a href="{{ route('pieza_dental.create') }}" class="btn btn-success btn-sm">Crear Pieza Dental</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Diente</th>
                            <th>Nombre</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($piezaDentales as $pieza)
                            <tr>
                                <td>{{ $pieza->id }}</td>
                                <td>{{ $pieza->diente }}</td>
                                <td>{{ $pieza->nombre }}</td>
                                <td>{{ $pieza->observacion }}</td>
                                <td>
                                    <a href="{{ route('pieza_dental.edit', $pieza->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <!-- Formulario de eliminación -->
                                    <form action="{{ route('pieza_dental.destroy', $pieza->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta pieza dental?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
