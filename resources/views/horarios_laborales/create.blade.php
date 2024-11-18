@extends('adminlte::page')
@section('title', 'Crear Horario')
@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Crear Horario') }}</div>
        <div class="card-body">
            <form action="{{ route('horarios_laborales.store') }}" method="POST">
                @csrf
                <br>
                <div class="row mb-3">
                    <label for="user_id" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>
                    <div class="col-md-6">
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror"
                            required>
                            <option value="" disabled selected>Seleccione un usuario</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name . ' ' . $user->apellido_p }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="start_datetime" class="col-md-4 col-form-label text-md-end">{{ __('Hora de Inicio') }}</label>

                    <div class="col-md-6">
                        <input type="datetime-local" id='start_datetime' name="start_datetime" id="start_datetime"
                            class="form-control @error('start_datetime') is-invalid @enderror" required />

                        @error('start_datetime')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="end_datetime" class="col-md-4 col-form-label text-md-end">{{ __('Hora de termino') }}</label>

                    <div class="col-md-6">
                        <input type="datetime-local" name="end_datetime" id="end_datetime"
                            class="form-control @error('end_datetime') is-invalid @enderror" required />

                        @error('start_datetime')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="estado" class="col-md-4 col-form-label text-md-end">{{ __('Estado') }}</label>

                    <div class="col-md-6">
                        <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>

                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Notas adicionales -->
                <div class="row mb-3">
                    <label for="notes" class="col-md-4 col-form-label text-md-end">{{ __('Notas Adicionales') }}</label>

                    <div class="col-md-6">
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"></textarea>

                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Tipo de horario -->
                <div class="row mb-3">
                    <label for="schedule_type" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de horario') }}</label>

                    <div class="col-md-6">
                        <select id="schedule_type" name="schedule_type"
                            class="form-control @error('schedule_type') is-invalid @enderror" required>
                            <option value="Normal" selected>Normal</option>
                            <option value="Extra">Extra</option>
                            <option value="Vacaciones">Vacaciones</option>
                        </select>

                        @error('schedule_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Botón para enviar el formulario -->
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4"> <!-- Centra el botón en la columna -->
                        <button type="submit" class="btn btn-primary">Crear Horario</button>
                    </div>
                </div>
            </form>

            <!-- Enlace para volver a la lista -->
            <a href="{{ route('horarios_laborales.index') }}" class="btn btn-secondary mt-3">Volver a la lista de
                horarios</a>

        </div>
    </div>
</div>
<script>
    (function() {
        document.getElementById('start_datetime').addEventListener('change', function() {
            document.getElementById('end_datetime').value = this.value;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

            document.getElementById('start_datetime').setAttribute('min', minDateTime);
            document.getElementById('end_datetime').setAttribute('min', minDateTime);
        });
    })();
</script>
@endsection