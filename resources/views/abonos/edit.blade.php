
@extends('adminlte::page')

@section('title', 'Editar Abono')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Editar Abono') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('abonos.update', $abono->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="monto_abono" class="text-gray-700 font-medium">{{ __('Monto') }}</label>
                        <input id="monto_abono" type="number" class="form-control @error('monto_abono') is-invalid @enderror" name="monto_abono" value="{{ $abono->monto_abono }}" min="0" required>
                        @error('monto_abono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_abono" class="text-gray-700 font-medium">{{ __('Fecha') }}</label>
                        <input id="fecha_abono" type="datetime-local" class="form-control @error('fecha_abono') is-invalid @enderror" name="fecha_abono" value="{{ $abono->fecha_abono }}" required>
                        @error('fecha_abono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago" class="text-gray-700 font-medium">{{ __('Método de Pago') }}</label>
                        <select id="metodo_pago" class="form-control @error('metodo_pago') is-invalid @enderror" name="metodo_pago" required>
                            <option value="Efectivo" {{ $abono->metodo_pago == 'Efectivo' ? 'selected' : '' }}>{{ __('Efectivo') }}</option>
                            <option value="Tarjeta Crédito" {{ $abono->metodo_pago == 'Tarjeta Crédito' ? 'selected' : '' }}>{{ __('Tarjeta Crédito') }}</option>
                            <option value="Tarjeta Débito" {{ $abono->metodo_pago == 'Tarjeta Débito' ? 'selected' : '' }}>{{ __('Tarjeta Débito') }}</option>
                            <option value="Transferencia" {{ $abono->metodo_pago == 'Transferencia' ? 'selected' : '' }}>{{ __('Transferencia') }}</option>
                        </select>
                        @error('metodo_pago')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="notas" class="text-gray-700 font-medium">{{ __('Notas') }}</label>
                        <input id="notas" type="text" class="form-control @error('notas') is-invalid @enderror" name="notas" value="{{ $abono->notas }}">
                        @error('notas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary">Actualizar Abono</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection