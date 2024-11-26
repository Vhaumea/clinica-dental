@extends('adminlte::page')

@section('title', 'Lista de Presupuestos')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ __('Listado de Presupuestos') }}</span>
            <a href="{{ route('presupuestos.create') }}" class="btn btn-success btn-sm">Crear Presupuesto</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente ID</th>
                        <th>Subtotal</th>
                        <th>Descuento</th>
                        <th>Total Final</th>
                        <th>Saldo Pendiente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presupuestos as $presupuesto)
                    <tr>
                        <td>{{ $presupuesto->id }}</td>
                        <td>{{ $presupuesto->paciente->nombre }} {{ $presupuesto->paciente->apellido_p }} {{ $presupuesto->paciente->apellido_m }}</td>
                        <td>{{ $presupuesto->subtotal }}</td>
                        <td>{{ $presupuesto->descuento }}</td>
                        <td>{{ $presupuesto->total_final }}</td>
                        <td>{{ $presupuesto->saldo_pendiente }}</td>
                        <td>{{ $presupuesto->estado }}</td>
                        <td>
                            <a href="{{ route('presupuestos.edit', $presupuesto->id) }}" class="btn btn-primary btn-sm">Editar</a>

                            <!-- Formulario de eliminación -->
                            <form action="{{ route('presupuestos.destroy', $presupuesto->id) }}" method='POST' style='display:inline;'>
                                @csrf
                                @method('DELETE')
                                <button type='submit' onclick='return confirm("¿Estás seguro de que deseas eliminar este presupuesto?")' class='btn btn-danger btn-sm'>Eliminar</button>
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