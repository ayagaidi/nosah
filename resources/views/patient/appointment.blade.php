@extends('patient.app')

@section('title', 'المواعيد')

@section('content')
<style>
    .fc .fc-button {
        background-color: #73a22a !important;
        color: white !important;
    }
    .fc .fc-button:hover {
        background-color: #73a22a !important;
    }
    .fc-timegrid-event-harness-inset .fc-timegrid-event,
    .fc-timegrid-event.fc-event-mirror,
    .fc-timegrid-more-link {
        background-color: #16a5b9 !important;
        color: white !important;
        height: fit-content !important;
    }
    .fc-timegrid-event:hover {
        background-color: #004d4f !important;
    }
</style>

<div class="inner-welcome pt85 bg4">
    <div class="container text-center">
        <div class="title">
            <h1>المواعيد</h1>
        </div>
        <div class="bread-crumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">المواعيد</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="appointments-section py-5">
    <h2 class="text-center text-primary mb-4">تقويم المواعيد</h2>
    <div id="calendar" style="max-width: 900px; margin: 0 auto;"></div>
</section>

<section class="appointments-list mt-5">
    <h3 class="text-center text-primary mb-4">قائمة المواعيد</h3>
    <div class="container">
        <div class="row g-4">
            @forelse($appointments as $appointment)
                @php
                    $carbonDate = \Carbon\Carbon::parse($appointment->scheduled_at)->subHours(2)->setTimezone('Africa/Tripoli');
                    $isToday = $carbonDate->isToday();
                    $time = $carbonDate->format('h:i A');
                    $date = $carbonDate->format('Y-m-d');
                    $bgColor = $isToday ? 'border-success shadow bg-light' : 'border-secondary';
                @endphp

                <div class="col-md-6">
                    <div class="card {{ $bgColor }} border-2 rounded-3 p-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fa fa-calendar text-success"></i>
                                {{ $date }} - {{ $time }}
                            </h5>
                            <p class="mb-1"><strong>الطبيب:</strong> {{ $appointment->doctor->fullname ?? '-' }}</p>
                            <p class="mb-1"><strong>العيادة:</strong> {{ $appointment->clinic->name ?? '-' }}</p>
                            <p class="mb-1"><strong>نوع الموعد:</strong> {{ $appointment->appointment_type ?? '-' }}</p>
                            <p class="mb-0">
                                <strong>الحالة:</strong>
                                <span class="badge {{ $appointment->status === 'confirmed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $appointment->status ?? 'غير محدد' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">لا توجد مواعيد حالياً.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- FullCalendar CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'ar',
        direction: 'rtl',
        timeZone: 'local',
        headerToolbar: {
            left: 'today,prev,next',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'اليوم',
            month: 'شهر',
            week: 'أسبوع',
            day: 'يوم',
            list: 'قائمة'
        },
        themeSystem: 'standard',
        allDaySlot: false,
        slotMinTime: "06:00:00",
        slotMaxTime: "22:00:00",
        events: [
            @foreach($appointments as $appointment)
                {
                    title: @json(($appointment->clinic->name ?? '-') . ' - ' . ($appointment->doctor->fullname ?? '-') . ' - ' . ($appointment->appointment_type ?? '-')),
                    start: @json(\Carbon\Carbon::parse($appointment->scheduled_at)->subHours(2)->setTimezone('Africa/Tripoli')->toIso8601String()),
                    end: @json(\Carbon\Carbon::parse($appointment->scheduled_at)->subHours(2)->setTimezone('Africa/Tripoli')->addHour()->toIso8601String()),
                    extendedProps: {
                        clinic: @json($appointment->clinic->name ?? '-'),
                        doctor: @json($appointment->doctor->fullname ?? '-'),
                        appointment_type: @json($appointment->appointment_type ?? '-'),
                        time: @json(\Carbon\Carbon::parse($appointment->scheduled_at)->subHours(2)->setTimezone('Africa/Tripoli')->format("h:i A"))
                    },
                    color: '#16a5b9',
                    textColor: 'white'
                },
            @endforeach
        ],
        eventContent: function(arg) {
            let containerEl = document.createElement('div');
            containerEl.style.color = '#fff';

            let iconEl = document.createElement('i');
            iconEl.classList.add('fa', 'fa-calendar');
            iconEl.style.marginRight = '5px';

            let titleEl = document.createElement('div');
            titleEl.textContent = arg.event.title;

            let timeEl = document.createElement('div');
            timeEl.style.fontSize = '0.8em';
            timeEl.textContent = arg.event.extendedProps.time;

            containerEl.appendChild(iconEl);
            containerEl.appendChild(titleEl);
            containerEl.appendChild(timeEl);

            return { domNodes: [containerEl] };
        }
    });

    calendar.render();
});
</script>
@endsection
