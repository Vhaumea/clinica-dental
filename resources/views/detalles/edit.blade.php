@extends('adminlte::page')

@section('title', 'Editar Detalle del Presupuesto')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')

    <!-- Tarjeta para la edición del detalle del presupuesto -->
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Editar Detalle del Presupuesto') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('detalles.update', $detalle->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="form-group">
                        <label for="pieza" class="text-gray-700 font-medium">{{ __('Pieza') }}</label>
                        <input id="pieza" type="text" class="form-control @error('pieza') is-invalid @enderror" name="pieza" value="{{ $detalle->pieza }}" required>
                        @error('pieza')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tratamiento" class="text-gray-700 font-medium">{{ __('Tratamiento') }}</label>
                        <input id="tratamiento" type="text" class="form-control @error('tratamiento') is-invalid @enderror" name="tratamiento" value="{{ $detalle->tratamiento }}" required>
                        @error('tratamiento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="observaciones" class="text-gray-700 font-medium">{{ __('Observaciones') }}</label>
                        <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" rows="3" required>{{ $detalle->observaciones }}</textarea>
                        @error('observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="precio" class="text-gray-700 font-medium">{{ __('Precio') }}</label>
                        <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" name="precio" value="{{ $detalle->precio }}" min="0" required>
                        @error('precio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tratamiento_estado" class="text-gray-700 font-medium">{{ __('Estado Tratamiento') }}</label>
                        <select id="tratamiento_estado" name="tratamiento_estado" class="form-control @error('tratamiento_estado') is-invalid @enderror" required>
                            <option value="Pendiente" {{ $detalle->tratamiento_estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En proceso" {{ $detalle->tratamiento_estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="Completado" {{ $detalle->tratamiento_estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                        </select>
                        @error('tratamiento_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary">Actualizar Detalle</button>
                </div>
            </form>
            <div class="text-left my-3">
                <a href="{{ route('presupuestos.edit', $detalle->presupuesto_id) }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection