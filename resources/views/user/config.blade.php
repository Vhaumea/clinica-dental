@extends('adminlte::page')

@section('title', 'Config')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Configuración de usuario') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('includes.avatar')
                <br>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Rol') }}</label>
                        <input id="role" type="text" class="form-control mt-1 block w-full @error('role') is-invalid @enderror" name="role" value="{{ Auth::user()->role }}" autocomplete="role" autofocus disabled>
                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700">{{ __('RUT') }}</label>
                        <input id="rut" type="text" class="form-control mt-1 block w-full @error('rut') is-invalid @enderror" name="rut" value="{{ Auth::user()->rut }}" autocomplete="rut" autofocus disabled>
                        @error('rut')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre Completo') }}</label>
                        <input id="name" type="text" class="form-control mt-1 block w-full @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }} {{ Auth::user()->apellido_p }} {{ Auth::user()->apellido_m }}" autocomplete="name" autofocus disabled>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control mt-1 block w-full @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" autocomplete="email" disabled>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Teléfono') }}</label>
                        <input id="phone" type="text" class="form-control mt-1 block w-full @error('phone') is-invalid @enderror" name="phone" value="{{ Auth::user()->phone }}" {{ $modo === 'ver' ? 'disabled' : 'required' }} autocomplete="phone" autofocus>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Campo para región -->
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700">{{ __('Región') }}</label>
                        <input id="region" type="text" class="form-control mt-1 block w-full @error('region') is-invalid @enderror" name="region" value="{{ Auth::user()->region }}" {{ $modo === 'ver' ? 'disabled' : 'required' }} autocomplete="region" autofocus>
                        @error('region')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Campo para comuna -->
                    <div>
                        <label for="comuna" class="block text-sm font-medium text-gray-700">{{ __('Comuna') }}</label>
                        <input id="comuna" type="text" class="form-control mt-1 block w-full @error('comuna') is-invalid @enderror" name="comuna" value="{{ Auth::user()->comuna }}" {{ $modo === 'ver' ? 'disabled' : 'required' }} autocomplete="comuna" autofocus>
                        @error('comuna')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                        <input id="direccion" type="text" class="form-control mt-1 block w-full @error('direccion') is-invalid @enderror" name="direccion" value="{{ Auth::user()->direccion }}" {{ $modo === 'ver' ? 'disabled' : 'required' }} autocomplete="direccion" autofocus>
                        @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Foto de Perfil') }}</label>
                        <input id="image" type="file" class="form-control mt-1 block w-full @error('image') is-invalid @enderror" name="image" accept="image/*" {{ $modo === 'ver' ? 'disabled' : '' }}> <!-- Permite solo imágenes -->
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @if ($modo === 'editar')
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Guardar') }}</button>
                </div>
                @endif
            </form>

            @if ($modo === 'editar')
            <form id="change-password-form" action="{{ route('user.change-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex justify-center mt-4">
                    <button type="button" id="change-password-btn" class="bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-600">{{ __('Cambiar Contraseña') }}</button>
                </div>
            </form>
            @endif
        </div>
    </div>
    <div class="flex justify-end mt-4">
        @if ($modo === 'ver')
        <a href="{{ route('config', ['modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">{{ __('Editar') }}</a>
        @else
        <a href="{{ route('config', ['modo' => 'ver']) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Cancelar') }}</a>
        @endif
    </div>
</div>
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('change-password-btn').addEventListener('click', function() {
        Swal.fire({
            title: 'Cambiar Contraseña',
            html: `
                <div class="mb-3">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">{{ __('Contraseña Actual') }}</label>
                    <input id="current_password" type="password" class="form-control mt-1 block w-full" name="current_password" required autocomplete="current-password">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">{{ __('Nueva Contraseña') }}</label>
                    <input id="new_password" type="password" class="form-control mt-1 block w-full" name="new_password" required autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirmar Nueva Contraseña') }}</label>
                    <input id="new_password_confirmation" type="password" class="form-control mt-1 block w-full" name="new_password_confirmation" required autocomplete="new-password">
                </div>
                <div id="error-message" class="text-red-500 mt-2"></div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                const currentPassword = Swal.getPopup().querySelector('#current_password').value;
                const newPassword = Swal.getPopup().querySelector('#new_password').value;
                const newPasswordConfirmation = Swal.getPopup().querySelector('#new_password_confirmation').value;
                let errorMessage = '';

                if (!currentPassword) {
                    errorMessage += 'La contraseña actual es requerida.<br>';
                }
                if (!newPassword) {
                    errorMessage += 'La nueva contraseña es requerida.<br>';
                }
                if (newPassword.length < 8) {
                    errorMessage += 'La nueva contraseña debe tener al menos 8 caracteres.<br>';
                }
                if (newPassword !== newPasswordConfirmation) {
                    errorMessage += 'La confirmación de la nueva contraseña no coincide.<br>';
                }

                if (errorMessage) {
                    Swal.showValidationMessage(errorMessage);
                    return false;
                }

                const form = document.createElement('form');
                form.action = "{{ route('user.change-password') }}";
                form.method = 'POST';
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="current_password" value="${currentPassword}">
                    <input type="hidden" name="new_password" value="${newPassword}">
                    <input type="hidden" name="new_password_confirmation" value="${newPasswordConfirmation}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@endsection