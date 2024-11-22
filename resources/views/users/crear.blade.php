@extends('adminlte::page')

@section('title', 'Crear Usuarios')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Crear Usuarios') }}</div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>
                    <div class="col-md-6">
                        <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required autofocus>
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
                </div>
                <div class="row mb-3">
                    <label for="rut" class="col-md-4 col-form-label text-md-end">{{ __('RUT') }}</label>

                    <div class="col-md-6">
                        <input id="rut" type="text" class="form-control @error('rut') is-invalid @enderror"
                            name="rut" autocomplete="rut" required autofocus>

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
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror" name="name"
                            autocomplete="name" required autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="apellido_p"
                        class="col-md-4 col-form-label text-md-end">{{ __('Apellido P') }}</label>

                    <div class="col-md-6">
                        <input id="apellido_p" type="text"
                            class="form-control @error('apellido_p') is-invalid @enderror" name="apellido_p"
                            autocomplete="apellido_p" required autofocus>

                        @error('apellido_p')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="apellido_m"
                        class="col-md-4 col-form-label text-md-end">{{ __('Apellido M') }}</label>

                    <div class="col-md-6">
                        <input id="apellido_m" type="text"
                            class="form-control @error('apellido_m') is-invalid @enderror" name="apellido_m"
                            autocomplete="apellido_m" required autofocus>

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
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            autocomplete="email" required>

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
                        <input id="phone" type="text"
                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                            required autofocus>

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="direccion"
                        class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>

                    <div class="col-md-6">
                        <input id="direccion" type="text"
                            class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                            required autofocus>

                        @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Registrar') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
