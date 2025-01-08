@extends('adminlte::page')
@section('title', 'Crear Paciente')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Crear Paciente') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <!-- Barra de progreso -->
            <div class="flex justify-center mb-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="0">1</div>
                    <div class="w-8 h-1 bg-gray-200"></div>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="1">2</div>
                    <div class="w-8 h-1 bg-gray-200"></div>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-black step-circle" data-step="2">3</div>
                </div>
            </div>

            <form action="{{ route('pacientes.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4 mb-4 text-black">

                    <div id="step1" class="step">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información Personal') }}</h3>
                        <div class="row mb-3">
                            <label for="rut" class="col-md-4 col-form-label text-md-end">{{ __('RUT') }}</label>
                            <div class="col-md-6">
                                <input id="rut" type="text" class="form-control @error('rut') is-invalid @enderror" name="rut" autocomplete="rut" required autofocus>
                                @error('rut')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" autocomplete="nombre" required autofocus>
                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido_p" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>
                            <div class="col-md-6">
                                <input id="apellido_p" type="text" class="form-control @error('apellido_p') is-invalid @enderror" name="apellido_p" autocomplete="apellido_p" required autofocus>
                                @error('apellido_p')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="apellido_m" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>
                            <div class="col-md-6">
                                <input id="apellido_m" type="text" class="form-control @error('apellido_m') is-invalid @enderror" name="apellido_m" autocomplete="apellido_m" required autofocus>
                                @error('apellido_m')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="btn-next bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Siguiente') }}</button>
                        </div>
                    </div>

                    <div id="step2" class="step hidden">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Información Adicional') }}</h3>
                        <div class="row mb-3">
                            <label for="sexo" class="col-md-4 col-form-label text-md-end">{{ __('Sexo') }}</label>
                            <div class="col-md-6">
                                <select id="sexo" name="sexo" class="form-control @error('sexo') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                @error('sexo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de Nacimiento') }}</label>
                            <div class="col-md-6">
                                <input id="birth" type="date" class="form-control @error('birth') is-invalid @enderror" name="birth" required>
                                @error('birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-between mt-4">
                            <button type="button" class="btn-prev bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Anterior') }}</button>
                            <button type="button" class="btn-next bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Siguiente') }}</button>
                        </div>
                    </div>

                    <div id="step3" class="step hidden">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Contacto') }}</h3>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" required autofocus>
                                @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Región -->
                        <div class="row mb-3">
                            <label for="region" class="col-md-4 col-form-label text-md-end">{{ __('Región') }}</label>
                            <div class="col-md-6">
                                <input id="region" type="text" class="form-control @error('region') is-invalid @enderror" name="region" value="{{ old('region') }}" required>
                                @error('region')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="comuna" class="col-md-4 col-form-label text-md-end">{{ __('Comuna') }}</label>
                            <div class="col-md-6">
                                <input id="comuna" type="text" class="form-control @error('comuna') is-invalid @enderror" name="comuna" value="{{ old('comuna') }}" required>
                                @error('comuna')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="direccion" class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>
                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" required autofocus>
                                @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo oculto para enviar el estado -->
                        <input type="hidden" name="estado" value="Activo">

                        <div class="flex justify-between mt-4">
                            <button type="button" class="btn-prev bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Anterior') }}</button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600">
                                {{ __('Registrar') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript para manejar la navegación entre pasos y la barra de progreso
    document.addEventListener("DOMContentLoaded", function() {
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.btn-next');
        const prevButtons = document.querySelectorAll('.btn-prev');
        const stepCircles = document.querySelectorAll('.step-circle');
        let currentStep = 0;

        // Mostrar el primer paso
        steps[currentStep].classList.remove('hidden');
        updateProgressBar();

        nextButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                // Validar el formulario actual
                const inputs = steps[currentStep].querySelectorAll('input, select');
                let valid = true;
                for (const input of inputs) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        valid = false;
                        break; // Detener la validación en el primer campo inválido
                    }
                }

                if (valid) {
                    // Ocultar el paso actual
                    steps[currentStep].classList.add('hidden');
                    // Avanzar al siguiente paso
                    currentStep++;
                    // Mostrar el siguiente paso si existe
                    if (currentStep < steps.length) {
                        steps[currentStep].classList.remove('hidden');
                    }
                    updateProgressBar();
                }
            });
        });

        prevButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                // Ocultar el paso actual
                steps[currentStep].classList.add('hidden');
                // Retroceder al paso anterior
                currentStep--;
                // Mostrar el paso anterior si existe
                if (currentStep >= 0) {
                    steps[currentStep].classList.remove('hidden');
                }
                updateProgressBar();
            });
        });

        function updateProgressBar() {
            stepCircles.forEach((circle, index) => {
                if (index <= currentStep) {
                    circle.classList.add('bg-blue-500', 'text-white');
                    circle.classList.remove('bg-gray-200', 'text-black');
                } else {
                    circle.classList.add('bg-gray-200', 'text-black');
                    circle.classList.remove('bg-blue-500', 'text-white');
                }
            });
        }
    });
</script>
@endsection