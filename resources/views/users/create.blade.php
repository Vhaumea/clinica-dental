@extends('adminlte::page')

@section('title', 'Crear Usuarios')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Crear Usuario') }}</div>
        <div class="card-body">



            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div id="step1" class="step"> {{ __('Ingresa el rol') }}

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Rol') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('role') is-invalid @enderror" required autofocus>
                                <option value="">Seleccione...</option>
                                <option value="Admin">Admin</option>
                                <option value="Recepcionista">Recepcionista</option>
                                <option value="Dentista">Dentista</option>
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="button" class="mt-4 btn-next">Siguiente</button>
                    </div>


                    <div id="step2" class="step hidden">
                        <div>
                            <label for="rut" class="block text-sm font-medium text-gray-700">{{ __('RUT') }}</label>
                            <input id="rut" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('rut') is-invalid @enderror" name="rut" autocomplete="rut" required autofocus>
                            @error('rut')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                            <input id="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('name') is-invalid @enderror" name="name" autocomplete="name" required autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="apellido_p" class="block text-sm font-medium text-gray-700">{{ __('Apellido P') }}</label>
                            <input id="apellido_p" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('apellido_p') is-invalid @enderror" name="apellido_p" autocomplete="apellido_p" required autofocus>
                            @error('apellido_p')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="apellido_m" class="block text-sm font-medium text-gray-700">{{ __('Apellido M') }}</label>
                            <input id="apellido_m" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('apellido_m') is-invalid @enderror" name="apellido_m" autocomplete="apellido_m" required autofocus>
                            @error('apellido_m')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div id="step2" class="step hidden">
                        <div>
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">{{ __('Fecha de Nacimiento') }}</label>
                            <input id="fecha_nacimiento" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" required>
                            @error('fecha_nacimiento')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="sexo" class="block text-sm font-medium text-gray-700">{{ __('Sexo') }}</label>
                            <select id="sexo" name="sexo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('sexo') is-invalid @enderror" required>
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
                        <button type="button" class="mt-4 btn-next">Siguiente</button>
                    </div>

                    <div id="step3" class="step hidden">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                            <input id="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('email') is-invalid @enderror" name="email" autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Teléfono') }}</label>
                            <input id="phone" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('phone') is-invalid @enderror" name="phone" required autofocus />
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                            <input id="direccion" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('direccion') is-invalid @enderror" name="direccion" required autofocus />
                            @error('direccion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="button" class="mt-4 btn-next">Siguiente</button>
                    </div>
                    <div id="step4" class="step hidden">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 @error('password') is-invalid @enderror" name="password" required />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200" name="password_confirmation" required />
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan hover:bg-cyan hover:bg-opacity-90 active:bg-opacity-80">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    // JavaScript para manejar la navegación entre pasos
    document.addEventListener("DOMContentLoaded", function() {
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.btn-next');
        let currentStep = 0;

        // Mostrar el primer paso
        steps[currentStep].classList.remove('hidden');

        nextButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                // Ocultar el paso actual
                steps[currentStep].classList.add('hidden');
                // Avanzar al siguiente paso
                currentStep++;
                // Mostrar el siguiente paso si existe
                if (currentStep < steps.length) {
                    steps[currentStep].classList.remove('hidden');
                }
            });
        });
    });
</script>
@endsection