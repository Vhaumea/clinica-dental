
@extends('adminlte::page')

@section('title', 'Usuarios')
@section('content')
<div class="container mx-auto p-4">
    @include('includes.message')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('Listado de usuarios') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100">
            <div class="overflow-x-auto">
                <table id="usuariosTable" class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Rol</th>
                            <th class="py-3 px-6 text-left">Rut</th>
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Apellidos</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Telefono</th>
                            <th class="py-3 px-6 text-left">Direccion</th>
                            <th class="py-3 px-6 text-left">Estado</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($usuarios as $usuario)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $usuario->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $usuario->role }}</td>
                            <td class="py-3 px-6 text-left">{{ $usuario->rut }}</td>
                            <td class="py-3 px-6 text-left">{{ $usuario->name }}</td>
                            <td class="py-3 px-6 text-left">{{ $usuario->apellido_p }} {{ $usuario->apellido_m }}</td>
                            <td class="py-3 px-6 text-left">{{ $usuario->email }}</td>
                            <td class="py-3 px-6 text-left">{{ $usuario->phone }}</td>
                            <td class="py-3 px-6 text-left">
                               Region {{ $usuario->region }}, {{ $usuario->comuna }}, {{ $usuario->direccion }}
                            </td>
                            <td class="py-3 px-6 text-left">{{ $usuario->estado }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('users.edit', ['id' => $usuario->id, 'modo' => 'ver']) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">
                                        Ver
                                    </a>
                                    @if(Auth::check() && Auth::user()->isAdmin())
                                    <a href="{{ route('users.edit', ['id' => $usuario->id, 'modo' => 'editar']) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-yellow-600">
                                        Editar
                                    </a>
                                    <form action="{{ route('users.toggleStatus', $usuario->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="py-2 px-4 rounded-md shadow-sm {{ $usuario->estado === 'Activo' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                            {{ $usuario->estado === 'Activo' ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#usuariosTable').DataTable({
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
</script>
@endsection
@endsection