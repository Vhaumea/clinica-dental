@extends('adminlte::page')

@section('title', 'Configuración de Horario')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Configuración de Horario') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <!-- Formulario para editar el horario -->
            <form id="horarioForm" action="{{ route('horarios_laborales.update', $horarios->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('Usuario') }}</label>
                        <input id="user_id" type="text" class="form-control mt-1 block w-full" value="{{ $horarios->user->name . ' ' . $horarios->user->apellido_p }}" readonly>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">{{ __('Fecha de Inicio') }}</label>
                        <input type="text" id="start_date" class="form-control mt-1 block w-full" value="{{ \Carbon\Carbon::parse($horarios->start_datetime)->format('Y-m-d') }}" readonly>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">{{ __('Hora de Inicio') }}</label>
                        <input type="time" id="start_time" name="start_time" value="{{ \Carbon\Carbon::parse($horarios->start_datetime)->format('H:i') }}" class="form-control mt-1 block w-full @error('start_time') is-invalid @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required />
                        @error('start_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input type="hidden" id="start_datetime" name="start_datetime">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('Fecha de Término') }}</label>
                        <input type="text" id="end_date" class="form-control mt-1 block w-full" value="{{ \Carbon\Carbon::parse($horarios->end_datetime)->format('Y-m-d') }}" readonly>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">{{ __('Hora de Término') }}</label>
                        <input type="time" id="end_time" name="end_time" value="{{ \Carbon\Carbon::parse($horarios->end_datetime)->format('H:i') }}" class="form-control mt-1 block w-full @error('end_time') is-invalid @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required />
                        @error('end_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input type="hidden" id="end_datetime" name="end_datetime">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('Notas Adicionales') }}</label>
                        <textarea name="notes" id="notes" class="form-control mt-1 block w-full @error('notes') is-invalid @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }}>{{ old('notes', $horarios->notes) }}</textarea>
                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="schedule_type" class="block text-sm font-medium text-gray-700">{{ __('Tipo de Horario') }}</label>
                        <select id="schedule_type" name="schedule_type" class="form-control mt-1 block w-full @error('schedule_type') is-invalid @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                            <option value="Normal" {{ $horarios->schedule_type === 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Extra" {{ $horarios->schedule_type === 'Extra' ? 'selected' : '' }}>Extra</option>
                        </select>
                        @error('schedule_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">{{ __('Estado') }}</label>
                        <select id="estado" name="estado" class="form-control mt-1 block w-full @error('estado') is-invalid @enderror" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                            <option value="Activo" {{ (old('estado', $horarios->estado) == 'Activo') ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ (old('estado', $horarios->estado) == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
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
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Actualizar Horario') }}</button>
                </div>
                @endif
            </form>

            <!-- Botones para cambiar entre modos -->
            <div class="flex justify-between mt-4">
                <!-- Enlace para volver a la lista -->
                <a href="{{ route('horarios_laborales.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Volver a la lista') }}</a>

                <div class="flex space-x-2">
                    @if(Auth::check() && Auth::user()->isAdmin())
                    @if (isset($modo) && $modo === 'ver')
                    <a href="{{ route('horarios_laborales.edit', ['id' => $horarios->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">Editar</a>
                    @else
                    <a href="{{ route('horarios_laborales.edit', ['id' => $horarios->id, 'modo' => 'ver']) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">Ver</a>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('js')
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('horarioForm');
        form.addEventListener('submit', function() {
            const startDate = document.getElementById('start_date').value;
            const startTime = document.getElementById('start_time').value;
            const endDate = document.getElementById('end_date').value;
            const endTime = document.getElementById('end_time').value;

            document.getElementById('start_datetime').value = `${startDate} ${startTime}`;
            document.getElementById('end_datetime').value = `${endDate} ${endTime}`;
        });

        flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        flatpickr("#end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    });
</script>
@endpush

@endsection