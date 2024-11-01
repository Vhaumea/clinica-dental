@extends('adminlte::page')

@section('title', 'Configuracion de Usuarios')

@section('content')
    <div class="container">
        @include('includes.message')
        <div class="card">
            <div class="card-header">{{ __('Configuracion de Usuarios') }}</div>
            <div class="card-body">
                <form action="{{ route('users.update', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>
                        <div class="col-md-6">
                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror"
                                disabled required autofocus>
                                <option value="Admin" {{ $usuario->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Recepcionista" {{ $usuario->role === 'Recepcionista' ? 'selected' : '' }}>
                                    Recepcionista</option>
                                <option value="Dentista" {{ $usuario->role === 'Dentista' ? 'selected' : '' }}>Dentista
                                </option>
                            </select>

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="rut" class="col-md-4 col-form-label text-md-end">{{ __('RUT') }}</label>

                        <div class="col-md-6">
                            <input id="rut" type="text" class="form-control @error('rut') is-invalid @enderror"
                                name="rut" value="{{ $usuario->rut }}" disabled required autofocus>

                            @error('rut')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ $usuario->name }}" disabled required autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="apellido_p" class="col-md-4 col-form-label text-md-end">{{ __('Apellido P') }}</label>

                        <div class="col-md-6">
                            <input id="apellido_p" type="text"
                                class="form-control @error('apellido_p') is-invalid @enderror" name="apellido_p"
                                value="{{ $usuario->apellido_p }}" disabled required autofocus>

                            @error('apellido_p')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="apellido_m" class="col-md-4 col-form-label text-md-end">{{ __('Apellido M') }}</label>

                        <div class="col-md-6">
                            <input id="apellido_m" type="text"
                                class="form-control @error('apellido_m') is-invalid @enderror" name="apellido_m"
                                value="{{ $usuario->apellido_m }}"disabled required autofocus>

                            @error('apellido_m')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sexo" class="col-md-4 col-form-label text-md-end">{{ __('Sexo') }}</label>
                        <div class="col-md-6">
                            <select id="sexo" name="sexo" class="form-control @error('sexo') is-invalid @enderror"
                                disabled required autofocus>
                                <option value="Femenino" {{ $usuario->sexo === 'Femenino' ? 'selected' : '' }}>Femenino
                                </option>
                                <option value="Masculino" {{ $usuario->sexo === 'Masculino' ? 'selected' : '' }}>Masculino
                                </option>
                                <option value="Otro" {{ $usuario->sexo === 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>

                            @error('sexo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $usuario->email }}"
                                {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Telefono') }}</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ $usuario->phone }}"
                                {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="direccion" class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>

                        <div class="col-md-6">
                            <input id="direccion" type="text"
                                class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                                value="{{ $usuario->direccion }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }}
                                required autofocus>

                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if (isset($modo) && $modo !== 'ver')
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Editar Usuario') }}
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
                <!-- Botones para cambiar entre modos -->
                <div class="d-flex justify-content-end">
                    @if(isset($modo) && $modo === 'ver')
                        <a href="{{ route('users.configuracion', ['id' => $usuario->id, 'modo' => 'editar']) }}" class="btn btn-warning">Editar</a>
                    @else
                        <a href="{{ route('users.configuracion', ['id' => $usuario->id, 'modo' => 'ver']) }}" class="btn btn-secondary">Ver</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
