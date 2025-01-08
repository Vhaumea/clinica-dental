@extends('adminlte::page')

@section('title', 'Crear Abono')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Crear Abono') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
           <!-- Mostrar el nombre del paciente, el total final, el total de abonos y el saldo pendiente -->
           <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div class="form-group">
                    <label for="nombre_paciente" class="text-gray-700 font-medium">{{ __('Nombre del Paciente') }}</label>
                    <input id="nombre_paciente" type="text" class="form-control" value="{{ $presupuesto->paciente->nombre }} {{ $presupuesto->paciente->apellido_p }} {{ $presupuesto->paciente->apellido_m }}" readonly>
                </div>
                <div class="form-group">
                    <label for="total_final" class="text-gray-700 font-medium">{{ __('Total Final') }}</label>
                    <input id="total_final" type="text" class="form-control" value="{{ $presupuesto->total_final }}" readonly>
                </div>
                <div class="form-group">
                    <label for="total_abonos" class="text-gray-700 font-medium">{{ __('Total de Abonos') }}</label>
                    <input id="total_abonos" type="text" class="form-control" value="{{ $totalAbonos }}" readonly>
                </div>
                <div class="form-group">
                    <label for="saldo_pendiente" class="text-gray-700 font-medium">{{ __('Saldo Pendiente') }}</label>
                    <input id="saldo_pendiente" type="text" class="form-control" value="{{ $saldoPendiente }}" readonly>
                </div>
            </div>
            <form action="{{ route('abonos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="presupuesto_id" value="{{ $presupuesto->id }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="monto_abono" class="text-gray-700 font-medium">{{ __('Monto') }}</label>
                        <input id="monto_abono" type="number" class="form-control @error('monto_abono') is-invalid @enderror" name="monto_abono" min="0" required>
                        @error('monto_abono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_abono" class="text-gray-700 font-medium">{{ __('Fecha') }}</label>
                        <input id="fecha_abono" type="datetime-local" class="form-control @error('fecha_abono') is-invalid @enderror" name="fecha_abono" required>
                        @error('fecha_abono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago" class="text-gray-700 font-medium">{{ __('Método de Pago') }}</label>
                        <select id="metodo_pago" class="form-control @error('metodo_pago') is-invalid @enderror" name="metodo_pago" required>
                            <option value="Efectivo">{{ __('Efectivo') }}</option>
                            <option value="Tarjeta Crédito">{{ __('Tarjeta Crédito') }}</option>
                            <option value="Tarjeta Débito">{{ __('Tarjeta Débito') }}</option>
                            <option value="Transferencia">{{ __('Transferencia') }}</option>
                        </select>
                        @error('metodo_pago')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="notas" class="text-gray-700 font-medium">{{ __('Notas') }}</label>
                        <input id="notas" type="text" class="form-control @error('notas') is-invalid @enderror" name="notas">
                        @error('notas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary">Crear Abono</button>
                </div>
                <div class="flex justify-between my-3">
                    <a href="{{ route('presupuestos.edit', $presupuesto->id) }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>

    </div>

    <!-- Lista de Abonos -->
    <div class="card shadow-lg rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Lista de Abonos') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Monto') }}</th>
                        <th>{{ __('Fecha') }}</th>
                        <th>{{ __('Método de Pago') }}</th>
                        <th>{{ __('Notas') }}</th>
                        <th>{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($abonos as $abono)
                    <tr>
                        <td>{{ $abono->monto_abono }}</td>
                        <td>{{ $abono->fecha_abono }}</td>
                        <td>{{ $abono->metodo_pago }}</td>
                        <td>{{ $abono->notas }}</td>
                        <td>
                            <a href="{{ route('abonos.edit', $abono->id) }}" class="btn btn-sm btn-warning">{{ __('Editar') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaAbonoInput = document.getElementById('fecha_abono');
        if (fechaAbonoInput) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
            fechaAbonoInput.value = formattedDate;
        }
    });
</script>
@endsection