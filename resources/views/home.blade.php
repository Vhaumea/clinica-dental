@extends('adminlte::page')

@section('title', 'Dashbaord')


@section('content_header')
<div> </div>
@stop

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
    <!-- Calendar -->
    <div class="bg-white p-4 rounded-lg shadow-lg col-span-1 lg:col-span-3 row-span-2 mb-4">
    <div class="flex flex-col lg:flex-row justify-between items-center">
        <div class="flex-grow text-center lg:text-left lg:ml-16 mb-4 lg:mb-0">
            <h2 class="text-xl font-bold lg:ml-16">Calendario de citas</h2>
        </div>
        <div class="text-left bg-white p-2 rounded-lg shadow-lg">
            <div class="flex items-center mb-2">
                <span class="w-4 h-4 bg-green-500 rounded-full inline-block mr-2"></span>
                <span>Completado</span>
            </div>
            <div class="flex items-center mb-2">
                <span class="w-4 h-4 bg-yellow-500 rounded-full inline-block mr-2"></span>
                <span>Pendiente - Confirmado</span>
            </div>
            <div class="flex items-center">
                <span class="w-4 h-4 bg-red-500 rounded-full inline-block mr-2"></span>
                <span>Cancelado - No Asistió</span>
            </div>
        </div>
    </div>
    <div id="calendar" class="mt-4 lg:mt-0"></div>
</div>

    <!-- Cards -->
    <div class="space-y-4 col-span-1">
        <!-- Card for Total Users -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 p-4 rounded-lg shadow-lg text-white text-center">
            <h2 class="text-xl font-bold">Medios de agendación</h2>
            <br>
            <p class="text-lg" style="margin-right: 0.4cm;">Presencial: {{ $presencial }} | Telefono: {{ $telefono }}</p>
            <p class="text-lg">Facebook: {{ $facebook }} | Whatsapp: {{ $whatsapp }}</p>
         </div>

        <!-- Card for Total Citas de hoy -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 p-4 rounded-lg shadow-lg text-white text-center">
            <h2 class="text-xl font-bold">Citas</h2>
            <br>
            <p class="text-lg">Ayer: {{ $totalCitasAyer }} | Hoy: {{ $totalCitasHoy }} | Mañana: {{ $totalCitasManana }}</p>
       
        </div>

        <!-- Card for Total Orders -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 p-4 rounded-lg shadow-lg text-white text-center">
            <h2 class="text-xl font-bold">Presupuestos</h2>
            <br>
            <p class="text-lg" style="margin-right: 0.4cm;">Completados: {{ $presupuestosCompletados }} | Rechazados: {{ $presupuestosRechazados }}</p>
            <p class="text-lg">Pendientes: {{ $presupuestosPendientes }} | En proceso: {{ $presupuestosEnproceso }}</p>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="text-xl font-bold">Estado de atenciones</h2>
                <br>
                <canvas id="pieChart"></canvas>
                
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Convertir las citas a eventos de FullCalendar
    const citas = @json($citas);
    const events = citas.map(cita => {
        let color;
        switch (cita.estado) {
            case 'Completada':
                color = 'green';
                break;
            case 'Pendiente':
            case 'Confirmada':
                color = '#d4b106'; // Color amarillo más oscuro
                break;
            case 'Cancelada':
                color = 'red';
                break;
            default:
                color = 'blue'; // Color por defecto
        }
        return {
            title: `Paciente: ${cita.paciente.nombre} ${cita.paciente.apellido_p} ${cita.paciente.apellido_m} Dentista: ${cita.user.name} ${cita.user.apellido_p} ${cita.user.apellido_m} \n \n Fecha: ${cita.fecha} Hora: ${cita.hora}`, 
            start: cita.fecha + 'T' + cita.hora,
            color: color,
            extendedProps: {
            pacienteNombre: `${cita.paciente.nombre} ${cita.paciente.apellido_p} ${cita.paciente.apellido_m}`,
            dentistaNombre: `${cita.user.name} ${cita.user.apellido_p} ${cita.user.apellido_m}`,
            fechaHora: ` ${cita.fecha} ${cita.hora}`
        }
        };
        
    });

    // FullCalendar
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es', // Configurar el idioma a español
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: events, // Pasar los eventos al calendario
            editable: false,
            eventLimit: true,
            eventClick: function(info) {
                Swal.fire({
                title: 'Agenda',
                html: `
                    <strong>Paciente:</strong> ${info.event.extendedProps.pacienteNombre}<br>
                    <strong>Dentista:</strong> ${info.event.extendedProps.dentistaNombre}<br>
                    <strong>Fecha y Hora:</strong> ${info.event.extendedProps.fechaHora}
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                customClass: {
                    popup: 'swal2-popup-custom',
                    title: 'swal2-title-custom',
                    htmlContainer: 'swal2-html-container-custom',
                    confirmButton: 'swal2-confirm-button-custom'
                }
            });

                
            }
        });
        calendar.render();

    });


    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Pendiente', 'Confirmada', 'Completada', 'Cancelada'],
            datasets: [{
                label: 'Atenciones',
                data: [{{ $pendientes }}, {{ $confirmadas }}, {{ $completadas }}, {{ $canceladas }}],
                backgroundColor: [
                    'rgba(241, 235, 65, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 102, 115, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgb(99, 206, 255)',
                    'rgb(54, 235, 117)',
                    'rgb(192, 75, 75)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@stop