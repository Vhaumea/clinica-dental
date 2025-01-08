@extends('adminlte::page')

@section('title', 'Página no encontrada')

@section('content')
<div class="container mx-auto p-4">
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-white text-black text-center py-4">
            <h2 class="text-lg font-semibold">{{ __('404 - Página no encontrada') }}</h2>
        </div>
        <div class="card-body p-6 bg-gray-100 text-center">
            <p>{{ __('Lo sentimos, la página que estás buscando no existe.') }}</p>
            <img src="{{ asset('images/error-01.png') }}" alt="Error 404" class="mx-auto my-4">
        </div>
    </div>
</div>
@endsection