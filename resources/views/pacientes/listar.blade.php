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
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pacientes as $paciente)
                            <tr>
                                <td>
                                    <a href="{{ route('pacientes.update', ['id' => $paciente->id]) }}">
                                        {{ $paciente->id }}
                                    </a>
                                </td>
                                <td>{{ $paciente->nombre }}</td>
                                <td>{{ $paciente->apellido_p }}</td>
                                <td>{{ $paciente->apellido_m }}</td>
                                <td>{{ $paciente->email }}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection