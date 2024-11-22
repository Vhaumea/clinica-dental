@extends('adminlte::page')

@section('title', 'Editar Presupuesto')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Editar Presupuesto') }}</div>
        <div class="card-body">
            <form action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Fila para tabla de detalles y resumen -->
                <div class="row">
                        <!-- Tabla de detalles -->
                        <div class="col-md-8">
                            <table id="tablaDetalles" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>N° Detalle</th>
                                        <th>Pieza</th>
                                        <th>Tratamiento</th>
                                        <th>Estado</th>
                                        <th>Precio</th>
                                        <th>Observaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaDetalles">
                                    @foreach($detalles as $index => $detalle)
                                    <tr>
                                        <td>{{ $detalle->id }}</td>
                                        <td>{{ $detalle->pieza_id }} - {{ $detalle->piezaDental->nombre ?? 'No disponible' }}</td>
                                        <td>{{ $detalle->tratamiento }}</td>
                                        <td>Activo</td> <!-- Cambia esto según tu lógica -->
                                        <td>{{ $detalle->precio }}</td>
                                        <td>{{ $detalle->observaciones }}</td>
                                        <td>
                                            <!-- Aquí puedes agregar botones para editar o eliminar -->
                                            <button type="button" class="btn btn-danger btn-sm eliminar-detalle" data-id="{{ $detalle->id }}">Eliminar</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Enlaces de paginación -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $detalles->links('pagination::bootstrap-4') }} <!-- Esto generará los enlaces de paginación -->
                            </div>
                        </div>

                        <!-- Resumen del presupuesto en un cuadro a la derecha -->
                        <div class="col-md-3">
                            <div class="card presupuesto-resumen">
                                <div class="card-header">{{ __('Resumen del Presupuesto') }}</div>
                                <div class="card-body">
                                    <p>Subtotal: <input type="text" id="subtotal" class="form-control" value="0" readonly /></p>
                                    <p>Descuento: <span id="descuento">0</span></p>
                                    <p>Total Final: <span id="totalFinal">0</span></p>
                                    <!-- Botón para guardar el presupuesto, colocado debajo de la tabla -->
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Guardar Presupuesto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>
</div>
@endsection
