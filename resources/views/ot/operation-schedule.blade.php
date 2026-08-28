@extends('layouts.structure')

@push('title')
    <title>Operation Schedule List</title>
@endpush

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
    <style>
        .fc .fc-toolbar {
            position: relative;
            z-index: 0;
        }

        .fc .fc-scrollgrid-section,
        .fc .fc-scrollgrid-section table,
        .fc .fc-scrollgrid-section>td {

            position: relative;
            z-index: 0;
        }
    </style>
@endpush

@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <div class="row">
                    <div class="col-md-6 card-title">
                        <h4 class="card-title card_hearder_mimi_text">Operation Theatre Schedule</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-10" id="calendar" style="height:500px; margin: auto;"></div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: '{{ route('ot.ot-calendar-events') }}',
                    method: 'GET',
                    failure: function() {
                        alert('There was an error while fetching OT schedule events.');
                    }
                },
                eventContent: function(arg) {
                    const startTime = arg.event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    const endTime = arg.event.end.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    return {
                        html: `
                <div style="font-size:12px; padding:4px;">
                    <b>${arg.event.title}</b><br>
                <span>OT Room: ${arg.event.extendedProps.room}</span><br>
                    <span>From: ${startTime}</span><br>
                <span>To: ${endTime}</span>
                </div>
            `
                    };
                },
                eventClick: function(info) {
                    const start = info.event.start.toLocaleString([], {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    const end = info.event.end.toLocaleString([], {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    const surgeons = info.event.extendedProps.surgean?.join(', ') || 'N/A';

                    alert(
                        'Scheduled OT:\n' +
                        info.event.title + '\n' +
                        'OT Room: ' + info.event.extendedProps.room + '\n' +
                        'From: ' + start + '\n' +
                        'To: ' + end + '\n' +
                        'Surgeon(s): ' + surgeons
                    );
                }

            });


            calendar.render();
        });
    </script>
@endpush
