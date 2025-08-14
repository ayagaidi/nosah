@extends('doctor.app')
@section('title', 'مواعيد المريض')

@section('content')
 <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">

                <h4 class="box-title">
                    <a href="{{ route('doctor.appointments.search') }}">المواعيد</a> / مواعيد المريض
                    {{ $patient->full_name }}
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <a href="{{ route('doctor.appointments.create', $patient->id) }}" class="btn btn-success mb-2">إضافة موعد جديد</a>
            <div class="table-responsive">
                <table id="appointments-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>التاريخ والوقت</th>
                            <th>النوع</th>
                            <th>العيادة</th>
                            <th>الطبيب</th>
                            <th>الحالة</th>
                            <th>ملاحظات</th>
                            <th>حضور</th>
                            <th>تعديل/تبديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- سيتم ملء البيانات عبر DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
$(function() {
    var table = $('#appointments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("doctor.appointments.ajax", $patient->id) }}',
        columns: [
            { data: 'scheduled_at', name: 'scheduled_at' },
            { data: 'appointment_type', name: 'appointment_type' },
            { data: 'clinic', name: 'clinic', orderable: false, searchable: false },
            { data: 'doctor', name: 'doctor', orderable: false, searchable: false },
            { data: 'status', name: 'status' },
            { data: 'notes', name: 'notes' },
            { data: 'attendance', name: 'attendance', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        "language": {
            "url": "../../../Arabic.json"
        },
    });

    // زر تغيير حالة الحضور
    $('#appointments-table').on('click', '.toggle-attendance', function() {
        var btn = $(this);
        var id = btn.data('id');
        var status = btn.data('status');
        $.ajax({
            url: '{{ route("doctor.appointments.toggleAttendance") }}',
            method: 'POST',
            data: {
                id: id,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    table.ajax.reload(null, false);
                }
            }
        });
    });
});
</script>
@endsection
