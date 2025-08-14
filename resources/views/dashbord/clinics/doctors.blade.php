@extends('layouts.app')
@section('title', 'الأطباء والتخصصات')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('clinics') }}">العيادات</a>/عرض الأطباء في عيادة {{$clinic->name}}</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">الأطباء والتخصصات - {{ $clinic->name }}</h4>
            <div class="table-responsive">
                <table id="doctorsTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>اسم الطبيب</th>
                            <th>التخصص</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clinic->doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->fullname }}</td>
                                <td>{{ $doctor->specializations->name ?? 'لا يوجد تخصص' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">لا يوجد أطباء</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#doctorsTable').dataTable({
            "language": {
                "url": "../../Arabic.json"
            },
            "lengthMenu": [5, 10],
            "bLengthChange": true,
            serverSide: false,
            paging: true,
            searching: true,
            ordering: true,
            dom: 'Blfrtip',
            buttons: [
                { extend: 'copyHtml5', text: 'نسخ' },
                { extend: 'excelHtml5', text: 'excel تصدير كـ' },
                { extend: 'colvis', text: 'الأعمدة' },
            ],
        });
    });
</script>
                       
     

</script>
@endsection


