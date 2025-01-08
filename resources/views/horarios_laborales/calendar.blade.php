
@extends('adminlte::page')
@section('title', 'Calendario de Horarios Laborales')

@section('content')
<div class="container mx-auto p-4">
    <div class="card shadow-lg rounded-lg overflow-hidden">
    <div class="card-header bg-white text-black text-center py-4 d-flex justify-content-center align-items-center">
    <h2 class="text-lg font-semibold m-0">{{ __('Calendario de Horarios Laborales') }}</h2>
</div>
        <div class="card-body p-6 bg-gray-100">
            <div id="calendar"></div>
        </div>
    </div>
</div>

@push('css')
<!-- FullCalendar CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" />
@endpush

@push('js')
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/es.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para generar un color hexadecimal aleatorio
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Asignar un color aleatorio a cada usuario
        var userColors = {};
        @foreach($horarios as $schedule)
            @if(!isset($userColors[$schedule->user->id]))
                userColors['{{ $schedule->user->id }}'] = getRandomColor();
            @endif
        @endforeach

        var events = [
            @foreach($horarios as $schedule) {
                title: '{{ $schedule->user->name }} - {{ substr($schedule->user->role, 0, 1) }} - {{ \Carbon\Carbon::parse($schedule->end_datetime)->format('H:i') }}',
                start: '{{ $schedule->start_datetime }}',
                end: '{{ $schedule->end_datetime }}',
                description: '{{ $schedule->notes }}',
                id: '{{ $schedule->id }}', // Asegúrate de tener el ID del horario
                color: userColors['{{ $schedule->user->id }}'] // Usar el color asignado al usuario
            },
            @endforeach
        ];

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: events,
            editable: false,
            eventLimit: true,
            locale: 'es', // Establecer el idioma a español
            eventClick: function(info) {
                const url = "{{ route('horarios_laborales.edit', ['id' => 'ID', 'modo' => 'ver']) }}".replace('ID', info.event.id);
                window.location.href = url;
            }
        });

        calendar.render();
    });
</script>
@endpush
@endsection