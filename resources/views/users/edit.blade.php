@extends('adminlte::page')

@section('title', 'Configuración de Usuarios')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Configuración de Usuarios') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('users.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Primera línea -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Rol') }}</label>
                        <select id="role" name="role" class="form-select mt-1 block w-full @error('role') border-red-500 @enderror bg-gray-200" disabled required autofocus>
                            <option value="Admin" {{ $usuario->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Recepcionista" {{ $usuario->role === 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                            <option value="Dentista" {{ $usuario->role === 'Dentista' ? 'selected' : '' }}>Dentista</option>
                        </select>
                        @error('role')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700">{{ __('RUT') }}</label>
                        <input id="rut" type="text" class="form-input mt-1 block w-full @error('rut') border-red-500 @enderror bg-gray-200" name="rut" value="{{ $usuario->rut }}" disabled required autofocus>
                        @error('rut')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                        <input id="name" type="text" class="form-input mt-1 block w-full @error('name') border-red-500 @enderror bg-gray-200" name="name" value="{{ $usuario->name }}" disabled required autofocus>
                        @error('name')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700">{{ __('Apellidos') }}</label>
                        <input id="apellidos" type="text" class="form-input mt-1 block w-full bg-gray-200 @error('apellidos') border-red-500 @enderror" name="apellidos" value="{{ $usuario->apellido_p . ' ' . $usuario->apellido_m }}" readonly required autofocus>
                        @error('apellidos')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Segunda línea -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label for="birth" class="block text-sm font-medium text-gray-700">{{ __('Fecha de Nacimiento') }}</label>
                        <input id="birth" type="text" class="form-input mt-1 block w-full @error('birth') border-red-500 @enderror bg-gray-200" name="birth" value="{{ $usuario->fecha_nacimiento }}" required autocomplete="bday" disabled>
                        @error('birth')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="sexo" class="block text-sm font-medium text-gray-700">{{ __('Sexo') }}</label>
                        <select id="sexo" name="sexo" class="form-select mt-1 block w-full @error('sexo') border-red-500 @enderror bg-gray-200" disabled required autofocus>
                            <option value="Femenino" {{ $usuario->sexo === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Masculino" {{ $usuario->sexo === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            
                        </select>
                        @error('sexo')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-input mt-1 block w-full @error('email') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="email" value="{{ $usuario->email }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>
                        @error('email')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Teléfono') }}</label>
                        <input id="phone" type="text" class="form-input mt-1 block w-full @error('phone') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="phone" value="{{ $usuario->phone }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>
                        @error('phone')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Tercera línea -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700">{{ __('Región') }}</label>
                        <input id="region" type="text" class="form-input mt-1 block w-full @error('region') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="region" value="{{ old('region', $usuario->region) }}" {{ isset($modo) && $modo === 'ver' ? 'readonly' : '' }} required autofocus>
                        @error('region')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="comuna" class="block text-sm font-medium text-gray-700">{{ __('Comuna') }}</label>
                        <input id="comuna" type="text" class="form-input mt-1 block w-full @error('comuna') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="comuna" value="{{ old('comuna', $usuario->comuna) }}" {{ isset($modo) && $modo === 'ver' ? 'readonly' : '' }} required autofocus>
                        @error('comuna')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                        <input id="direccion" type="text" class="form-input mt-1 block w-full @error('direccion') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="direccion" value="{{ $usuario->direccion }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>
                        @error('direccion')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">{{ __('Estado') }}</label>
                        <select id="estado" name="estado" class="form-select mt-1 block w-full @error('estado') border-red-500 @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : 'bg-white' }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                            <option value="Activo" {{ (old('estado', $usuario->estado) == 'Activo') ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ (old('estado', $usuario->estado) == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @if (isset($modo) && $modo !== 'ver')
                <div class="flex justify-center mb-0">
                    <button type="submit" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        {{ __('Editar Usuario') }}
                    </button>
                </div>
                @endif
            </form>

            <!-- Botones para cambiar entre modos -->
            <div class="flex justify-between mt-4">
                <!-- Botón para volver a la lista -->
                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">
                    Volver a la lista
                </a>

                <!-- Botones de modo -->
                @if(Auth::check() && Auth::user()->isAdmin())
                @if(isset($modo) && $modo === 'ver')
                <a href="{{ route('users.edit', ['id' => $usuario->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">
                    Editar
                </a>
                @else
                <a href="{{ route('users.edit', ['id' => $usuario->id, 'modo' => 'ver']) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">
                    Ver
                </a>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection