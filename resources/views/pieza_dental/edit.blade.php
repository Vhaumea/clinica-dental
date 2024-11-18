@extends('adminlte::page')

@section('title', 'Editar Pieza Dental')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header">{{ __('Editar Pieza Dental') }}</div>
        <div class="card-body">
            <form action="{{ route('pieza_dental.update', $piezaDental->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Diente -->
                <div class="row mb-3">
                    <label for="diente" class="col-md-4 col-form-label text-md-end">{{ __('Diente') }}</label>
                    <div class="col-md-6">
                        <input id="diente" type="text" class="form-control @error('diente') is-invalid @enderror" name="diente" value="{{ old('diente', $piezaDental->diente) }}" required>
                        @error('diente')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Nombre -->
                <div class="row mb-3">
                    <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                    <div class="col-md-6">
                        <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $piezaDental->nombre) }}" required>
                        @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Observación -->
                <div class="row mb-3">
                    <label for="observacion" class="col-md-4 col-form-label text-md-end">{{ __('Observación') }}</label>
                    <div class="col-md-6">
                        <input id="observacion" type="text" class="form-control @error('observacion') is-invalid @enderror" name="observacion" value="{{ old('observacion', $piezaDental->observacion) }}" required>
                        @error('observacion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Botón de submit -->
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Actualizar Pieza Dental') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection