@extends('adminlte::page')

@section('title', 'Configuración de Paciente')

@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Paciente') }}</h2>
        </div>
        <div class="card-body p-6 bg-white">
            <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700">{{ __('RUT') }}</label>
                        <input id="rut" type="text" class="form-control mt-1 block w-full @error('rut') is-invalid @enderror" name="rut" value="{{ $paciente->rut }}" disabled required autofocus>
                        @error('rut')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                        <input id="nombre" type="text" class="form-control mt-1 block w-full @error('nombre') is-invalid @enderror" name="nombre" value="{{ $paciente->nombre }}" disabled required autofocus>
                        @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700">{{ __('Apellidos') }}</label>
                        <input id="apellidos" type="text" class="form-control mt-1 block w-full bg-gray-200 @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ $paciente->apellido_p . ' ' . $paciente->apellido_m }}" readonly required autofocus>
                        @error('apellidos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="sexo" class="block text-sm font-medium text-gray-700">{{ __('Sexo') }}</label>
                        <select id="sexo" name="sexo" class="form-control mt-1 block w-full @error('sexo') is-invalid @enderror" disabled required autofocus>
                            <option value="Femenino" {{ $paciente->sexo === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Masculino" {{ $paciente->sexo === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Otro" {{ $paciente->sexo === 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('sexo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control mt-1 block w-full @error('email') is-invalid @enderror" name="email" value="{{ $paciente->email }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">{{ __('Telefono') }}</label>
                        <input id="telefono" type="text" class="form-control mt-1 block w-full @error('telefono') is-invalid @enderror" name="telefono" value="{{ $paciente->telefono }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>
                        @error('telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                        <input id="direccion" type="text" class="form-control mt-1 block w-full @error('direccion') is-invalid @enderror" name="direccion" value="{{ $paciente->direccion }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required autofocus>
                        @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700">{{ __('Región') }}</label>
                        <input id="region" type="text" class="form-control mt-1 block w-full @error('region') is-invalid @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="region" value="{{ old('region', $paciente->region) }}" {{ isset($modo) && $modo === 'ver' ? 'readonly' : '' }} required autofocus>
                        @error('region')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="comuna" class="block text-sm font-medium text-gray-700">{{ __('Comuna') }}</label>
                        <input id="comuna" type="text" class="form-control mt-1 block w-full @error('comuna') is-invalid @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" name="comuna" value="{{ old('comuna', $paciente->comuna) }}" {{ isset($modo) && $modo === 'ver' ? 'readonly' : '' }} required autofocus>
                        @error('comuna')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">{{ __('Estado') }}</label>
                        <select id="estado" name="estado" class="form-control mt-1 block w-full @error('estado') is-invalid @enderror {{ isset($modo) && $modo === 'ver' ? 'bg-gray-200' : '' }}" {{ isset($modo) && $modo === 'ver' ? 'disabled' : '' }} required>
                            <option value="Activo" {{ (old('estado', $paciente->estado) == 'Activo') ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ (old('estado', $paciente->estado) == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                @if (isset($modo) && $modo !== 'ver')
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Editar Paciente') }}</button>
                </div>
                <br>
                @endif
            </form>
            <hr>
            <!-- Información de la Ficha Clínica -->
            <div class="card-header bg-white text-black text-center py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-left">{{ __('Ficha Clínica') }}</h2>
                    <a href="{{ route('pacientes.presupuestos.index', $paciente->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">
                        Ver Presupuestos del Paciente
                    </a>
                </div>
                <br>
                <hr>
                @if ($fichaClinica)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Primera Fila -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Medicamentos') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->medicamentos }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Alergias') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->alergias }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Embarazo') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->embarazo ? 'Sí' : 'No' }}</p>
                        @if ($fichaClinica->embarazo)
                        <div class="mt-2 flex items-center w-full">
                            <h5 class="text-gray-700 font-semibold w-1/3">{{ __('Tiempo de Gestación') }}</h5>
                            <p class="text-gray-600 w-2/3">{{ $fichaClinica->tiempo_gestacion }} {{ __('semanas') }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Segunda Fila -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Enfermedades Sistémicas') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->enfermedades_sistemicas }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Hipertensión') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->hipertension ? 'Sí' : 'No' }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Diabetes') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->diabetes }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Otros') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->otros }}</p>
                    </div>

                    <!-- Tercera Fila -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Reacción Alérgica a Medicamento') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->reaccion_alergica_medicamento }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Reacción Alérgica a Anestesia') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->reaccion_alergica_anestesia }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center col-span-1">
                        <h4 class="text-gray-700 font-semibold w-1/3">{{ __('Observaciones') }}</h4>
                        <p class="text-gray-600 w-2/3">{{ $fichaClinica->observaciones }}</p>
                    </div>
                </div>
                @if(isset($modo) && $modo === 'editar')
                <div class="mt-4 text-center">
                    <a href="{{ route('fichas_clinicas.edit', ['fichas_clinica' => $fichaClinica->id]) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Editar Ficha Clínica') }}</a>
                </div>
                @endif
                @else
                <div class="mt-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-700">{{ __('No hay ficha clínica para este paciente.') }}</p>
                        <a href="{{ route('fichas_clinicas.create', ['paciente_id' => $paciente->id]) }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ __('Crear Ficha Clínica') }}</a>
                    </div>
                </div>
                @endif
            </div>
            <br>

            <!-- Contenedor de Citas y Notas de Evolución -->
            <div class="card-header bg-white text-black text-left py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">{{ __('Citas del Paciente') }}</h2>
                    <a href="{{ route('citas.create', ['paciente_id' => $paciente->id]) }}" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-green-600">
                        {{ __('Crear Cita') }}
                    </a>
                </div><br>

                @if ($citas->isNotEmpty())
                <div class="overflow-x-auto">
                    <table id="citasTable" class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 px-6 text-left">Fecha</th>
                                <th class="py-3 px-6 text-left">Hora</th>
                                <th class="py-3 px-6 text-left">Motivo</th>
                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($citas as $cita)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $cita->fecha }}</td>
                                <td class="py-3 px-6 text-left">{{ $cita->hora }}</td>
                                <td class="py-3 px-6 text-left">{{ $cita->motivo }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        <button onclick="verNotasEvolucion('{{ $cita->id }}')" class="bg-blue-500 text-white py-1 px-3 rounded-md shadow-sm hover:bg-blue-600">
                                            {{ __('Ver Notas de Evolución') }}
                                        </button>
                                        <a href="{{ route('citas.edit', ['cita' => $cita->id, 'modo' => 'editar']) }}" class="bg-green-500 text-white py-1 px-3 rounded-md shadow-sm hover:bg-green-600">
                                            {{ __('Crear Nota de Evolución') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="mt-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-700">{{ __('No hay citas para este paciente.') }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Botones para cambiar entre modos -->
            <div class="flex justify-between mt-4">
                <!-- Botón para volver a la lista -->
                <a href="{{ route('pacientes.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Volver a la lista') }}</a>

                <!-- Botones de modo -->
                <div class="flex space-x-2">
                    @if(isset($modo) && $modo === 'ver')
                    <a href="{{ route('pacientes.edit', ['id' => $paciente->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">{{ __('Editar') }}</a>
                    @else
                    <a href="{{ route('pacientes.edit', ['id' => $paciente->id, 'modo' => 'ver']) }}" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600">{{ __('Ver') }}</a>
                    @endif
                </div>
            </div>

            @section('js')
            <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
            <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                $(document).ready(function() {
                    $('#citasTable').DataTable({
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "Mostrar _MENU_ registros por página",
                            "zeroRecords": "No se encontraron resultados",
                            "info": "Mostrando página _PAGE_ de _PAGES_",
                            "infoEmpty": "No hay registros disponibles",
                            "infoFiltered": "(filtrado de _MAX_ total registros)",
                            "search": "Buscar:",
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        }
                    });
                });

                function verNotasEvolucion(citaId) {
                    console.log('Fetching notas de evolución for citaId:', citaId);
                    fetch(`/notas-evolucion/${citaId}`)
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Notas de evolución data:', data);
                            let content = '';
                            if (data.length > 0) {
                                data.forEach((nota, index) => {
                                    content += `
                            <div class="mb-4">
                                <h3 class="text-md font-semibold">Nota ID: ${nota.id}</h3>
                                <p><strong>Fecha:</strong> ${nota.fecha_nota}</p>
                                <p><strong>Descripción:</strong> ${nota.descripcion}</p>
                                <p><strong>Observaciones:</strong> ${nota.observaciones_evolucion}</p>
                                <p><strong>Estado:</strong> ${nota.estado_nota}</p>
                            </div>
                            <hr>
                        `;
                                });
                            } else {
                                content = '{{ __("No hay notas de evolución para esta cita.") }}';
                            }

                            Swal.fire({
                                title: 'Notas de Evolución',
                                html: content,
                                width: '80%',
                                confirmButtonText: 'Cerrar',
                                customClass: {
                                    popup: 'swal2-popup-custom',
                                    title: 'swal2-title-custom',
                                    htmlContainer: 'swal2-html-container-custom',
                                    confirmButton: 'swal2-confirm-button-custom'
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching notas de evolución:', error);
                        });
                }
            </script>
            <style>
                .swal2-popup-custom {
                    font-size: 1.2em;
                    border-radius: 10px;
                    max-width: 600px;
                }

                .swal2-title-custom {
                    color: #4A90E2;
                    font-weight: bold;
                }

                .swal2-html-container-custom {
                    text-align: left;
                }

                .swal2-confirm-button-custom {
                    background-color: #4A90E2;
                    color: white;
                    border-radius: 5px;
                    padding: 10px 20px;
                }
            </style>
            @endsection
        </div>
    </div>
</div>
@endsection