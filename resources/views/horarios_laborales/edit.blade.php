@extends('adminlte::page')

@section('title', 'Configuracion de horario')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Configuración de horario') }}</div>
        <div class="card-body">
            <!-- Formulario para editar el horario -->
            <form action="{{ route('horarios_laborales.update', $horarios->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="user_name" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="user_name" name="user_name"
                            value="{{ $horarios->user->name . ' ' . $horarios->user->apellido_p }}"
                            class="form-control @error('user_name') is-invalid @enderror" readonly />
                        @error('user_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="start_datetime"
                        class="col-md-4 col-form-label text-md-end">{{ __('Hora de Inicio') }}</label>
                    <div class="col-md-6">
                        <input type="datetime-local" id='start_datetime' name="start_datetime"
                            value="{{$horarios->start_datetime}}"
                            class="form-control @error('start_datetime') is-invalid @enderror"
                            {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required />
                        @error('start_datetime')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="end_datetime"
                        class="col-md-4 col-form-label text-md-end">{{ __('Hora de término') }}</label>
                    <div class="col-md-6">
                        <input type="datetime-local" name="end_datetime" id="end_datetime"
                            value="{{ $horarios->end_datetime }}"
                            class="form-control @error('end_datetime') is-invalid @enderror"
                            {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required />
                        @error('end_datetime')
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
                            <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo
                            </option>
                        </select>
                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="notes"
                        class="col-md-4 col-form-label text-md-end">{{ __('Notas Adicionales') }}</label>
                    <div class="col-md-6">
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"
                            {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }}>{{ old('notes') }}</textarea>
                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="schedule_type"
                        class="col-md-4 col-form-label text-md-end">{{ __('Tipo de Horario') }}</label>
                    <div class="col-md-6">
                        <select id="schedule_type" class="form-control" name="schedule_type"
                            class="form-select @error('schedule_type') is-invalid @enderror"
                            {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                            <option value="Normal" {{ old('schedule_type') == 'Normal' ? 'selected' : '' }}>Normal
                            </option>
                            <option value="Extra" {{ old('schedule_type') == 'Extra' ? 'selected' : '' }}>Extra
                            </option>
                            <option value="Vacaciones" {{ old('schedule_type') == 'Vacaciones' ? 'selected' : '' }}>
                                Vacaciones</option>
                        </select>
                        @error('schedule_type')
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
                        <button type="submit" class="btn btn-primary">{{ __('Actualizar Horario') }}</button>
                    </div>
                </div>
                @endif
            </form>

            <!-- Botones para cambiar entre modos -->
            <div class="d-flex justify-content-between mt-3">
                <!-- Enlace para volver a la lista (a la izquierda) -->
                <a href="{{ route('horarios_laborales.index') }}" class="btn btn-secondary">{{ __('Volver a la lista') }}</a>

                <div class="d-flex">
                    @if (isset($modo) && $modo === 'ver')
                    <a href="{{ route('horarios_laborales.edit', ['id' => $horarios->id, 'modo' => 'editar']) }}"
                        class="btn btn-warning ml-2">Editar</a>
                    @else
                    <a href="{{ route('horarios_laborales.edit', ['id' => $horarios->id, 'modo' => 'ver']) }}"
                        class="btn btn-secondary ml-2">Ver</a>
                    @endif
                </div>
            </div>

        </div>
        <script>
            (function() {
                document.getElementById('start_datetime').addEventListener('change', function() {
                    // Asignar el mismo valor de start_datetime a end_datetime
                    document.getElementById('end_datetime').value = this.value;
                });

                document.addEventListener('DOMContentLoaded', function() {
                    // Obtener la fecha y hora actuales
                    const now = new Date();

                    // Formatear la fecha en el formato adecuado para datetime-local
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0'); // Mes empieza desde 0
                    const day = String(now.getDate()).padStart(2, '0');
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');

                    // Crear una cadena en el formato YYYY-MM-DDTHH:MM
                    const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

                    // Asignar el valor mínimo al campo
                    document.getElementById('start_datetime').setAttribute('min', minDateTime);
                    document.getElementById('end_datetime').setAttribute('min', minDateTime);
                });
            })();
        </script>
        @endsection