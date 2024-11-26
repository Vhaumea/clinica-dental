@extends('adminlte::page')

@section('title','Dashboard')

@section('plugins.Datatables',true)
@section('plugins.FullCalendar',true)
@section('plugins.TailwindCSS',true)

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p> welcome </p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    
@stop

@section('js')
    <script> Swal.fire({
        title: "Good job!",
        text: "You clicked the button!",
        icon: "success"
      }); </script>
@stop    