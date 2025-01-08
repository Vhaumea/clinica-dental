@extends('adminlte::page')

@section('title', 'Editar Nota de Evolución')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Editar Nota de Evolución') }}</h2>
        </div>
        <div class="card-body p-6 bg-white">
            <form action="{{ route('notas_evolucion.update', $notaEvolucion->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripción') }}</label>
                        <textarea name="descripcion" id="descripcion" class="form-control mt-1 block w-full @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $notaEvolucion->descripcion) }}</textarea>
                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="observaciones_evolucion" class="block text-sm font-medium text-gray-700">{{ __('Observaciones') }}</label>
                        <textarea name="observaciones_evolucion" id="observaciones_evolucion" class="form-control mt-1 block w-full @error('observaciones_evolucion') is-invalid @enderror">{{ old('observaciones_evolucion', $notaEvolucion->observaciones_evolucion) }}</textarea>
                        @error('observaciones_evolucion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="estado_nota" class="block text-sm font-medium text-gray-700">{{ __('Estado') }}</label>
                        <select name="estado_nota" id="estado_nota" class="form-control mt-1 block w-full @error('estado_nota') is-invalid @enderror" required>
                            <option value="Activo" {{ old('estado_nota', $notaEvolucion->estado_nota) == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado_nota', $notaEvolucion->estado_nota) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado_nota')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Guardar Cambios') }}</button>
                    <a href="{{ route('citas.edit', ['cita' => $notaEvolucion->cita_id, 'modo' => 'editar']) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600 ml-2">{{ __('Cancelar') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection