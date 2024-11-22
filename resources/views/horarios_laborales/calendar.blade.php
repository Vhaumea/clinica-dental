@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ __('Calendario') }}</span>
            <a href="{{ route('horarios_laborales.index') }}" class="btn btn-secondary">{{ __('Volver a la lista') }}</a>
        </div>

        <div class="card-body">

            <div id="calendar"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var events = [
            @foreach($horarios as $schedule) {
                title: '{{ $schedule->user->name }} - {{ substr($schedule->user->role, 0, 1) }} - {{ \Carbon\Carbon::parse($schedule->end_datetime)->format('H:i') }}',
                start: '{{ $schedule->start_datetime }}',
                end: '{{ $schedule->end_datetime }}',
                description: '{{ $schedule->notes }}',
                id: '{{ $schedule->id }}', // Asegúrate de tener el ID del horario
                color: getRandomColor() // Asignar un color aleatorio
            },
            @endforeach
        ];

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: events,
            editable: false,
            eventLimit: true,
            locale: 'es', // Establecer el idioma a español
            eventClick: function(event) {
                const url =
                    "{{ route('horarios_laborales.edit', ['id' => 'ID', 'modo' => 'ver']) }}"
                    .replace('ID', event.id);
                window.location.href = url;
            }
        });

        // Función para generar un color hexadecimal aleatorio
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    });
</script>
@endsection