@extends('adminlte::page')

@section('title', 'Editar Presupuesto')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="card">
        <div class="card-header">{{ __('Editar Presupuesto') }}</div>
        <div class="card-body">
            <form action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Paciente ID -->
                <div class="row mb-3">
                    <label for "paciente_id" class "col-md-4 col-form-label text-md-end">{{ __('Paciente ID') }}</label> 
                    << div class "col-md-6"> 
                      << input id "paciente_id"
                      value="{{ old('paciente_id', $presupuesto->paciente_id) }}"
                      << div 

                <!-- Subtotal -->
                <div class = "row mb -3"> 
                  << label for = "subtotal"
                  value="{{ old('subtotal', $presupuesto->subtotal) }}"
                  << div 

                <!-- Descuento -->
                ...

                 <!-- Total Final -->
                 ...

                 <!-- Fecha -->
                 ...

                 <!-- Saldo Pendiente -->
                 ...

                 <!-- Estado -->
                 ...

                 <!-- Botón de submit -->
                 ...
            </form>
        </div>
    </div>
</div>
@endsection
