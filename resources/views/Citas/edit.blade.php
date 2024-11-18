@extends('adminlte::page')

@section('title', 'Editar Cita')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Editar Cita') }}</div>
        <div class="card-body">
            <form action="{{ route('citas.update', $cita->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Rut del Paciente -->
                <div class="row mb-3">
                    <label for="rut_paciente" class="col-md-4 col-form-label text-md-end">{{ __('Rut Paciente') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="rut_paciente" name="rut_paciente"
                            value="{{ $cita->paciente->rut}}"
                            class="form-control @error('rut_paciente') is-invalid @enderror" readonly />
                        @error('rut_paciente')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Campo de fecha y hora-->
                <div class="row mb-3">
                    <label for="fecha_hora" class="col-md-4 col-form-label text-md-end">{{ __('Fecha y hora') }}</label>
                    <div class="col-md-6">
                        <input type="datetime" id="fecha_hora" class="form-control" name="fecha_hora" value="{{ $cita->fecha . ' ' . $cita->hora}}" readonly required>
                    </div>
                </div>

                <!-- Campo de Dentista -->
                <div class="row mb-3">
                    <label for="user_nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre de Dentista') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="user_nombre" class="form-control" name="user_nombre" value="{{$cita->user->name . ' ' . $cita->user->apellido_p }}" readonly required>
                    </div>
                </div>

                <!-- Campo de motivo -->
                <div class="row mb-3">
                    <label for="motivo" class="col-md-4 col-form-label text-md-end">{{ __('Motivo') }}</label>
                    <div class="col-md-6">
                        <input id="motivo" type="text" class="form-control @error('motivo') is-invalid @enderror" name="motivo" value="{{ $cita->motivo }}" maxlength="255" readonly />
                        @error('motivo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Campo de origen -->
                <div class="row mb-3">
                    <label for="origen" class="col-md-4 col-form-label text-md-end">{{ __('Origen') }}</label>
                    <div class="col-md-6">
                        <input id="origen" type="text" class="form-control @error('origen') is-invalid @enderror" name="origen" value="{{ old('origen', $cita->origen) }}" readonly />

                        @error('origen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="row mb-3">
                    <label for="observaciones" class="col-md-4 col-form-label text-md-end">{{ __('Observaciones') }}</label>
                    <div class="col-md-6">
                        <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones">{{ old('observaciones', $cita->observaciones) }}</textarea>
                        @error('observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="estado" class="col-md-4 col-form-label text-md-end">{{ __('Estado') }}</label>
                    <div class="col-md-6">
                        <select name="estado" id="estado"
                            class="form-control @error('estado') is-invalid @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }}>
                            <option value="Pendiente" {{ old('estado', $cita->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Confirmada" {{ old('estado', $cita->estado) == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                            <option value="Cancelada" {{ old('estado', $cita->estado) == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="Completada" {{ old('estado', $cita->estado) == 'Completada' ? 'selected' : '' }}>Completada</option>
                        </select>
                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Botón para enviar el formulario -->
                @if (isset($modo) && $modo !== 'ver')
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Actualizar Cita') }}</button>
                    </div>
                </div>
                @endif
            </form>
            <!-- Botones para cambiar entre modos -->
            <div class="d-flex justify-content-between mt-3">
                <!-- Enlace para volver a la lista (a la izquierda) -->
                <a href="{{ route('citas.index') }}" class="btn btn-secondary">{{ __('Volver a la lista') }}</a>

                <div class="d-flex">
                    @if (isset($modo) && $modo === 'ver')
                    <a href="{{ route('citas.edit', ['id' => $cita->id, 'modo' => 'editar']) }}"
                        class="btn btn-warning ml-2">Editar</a>
                    @else
                    <a href="{{ route('citas.edit', ['id' => $cita->id, 'modo' => 'ver']) }}"
                        class="btn btn-secondary ml-2">Ver</a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection