@extends('doctor.app')
@section('title','المرضى')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <a type="button" href="{{ route('doctor.patients.create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">إضافة مريض</a>
        </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">عرض المرضى</h4>
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="datatable1" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="cursor: pointer;">
                        <thead>
                            <tr>
                                                                <th>رقم المريض</th>

                                <th>اسم المريض</th>
                                <th>تاريخ الميلاد</th>
                                <th>الجنس</th>
                                <th>رقم التواصل</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th></th>
                                                                <th></th>

                                <th></th>
                                <th>عرض ملف المريض</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script>
                                $(document).ready(function () {
                                    $('#datatable1').dataTable({
                                        "language": {
                                            "url": "../Arabic.json"
                                        },
                                        "lengthMenu": [5, 10],
                                        "bLengthChange": true,
                                        serverSide: false,
                                        paging: true,
                                        searching: true,
                                        ordering: true,
                                        ajax: '{!! route('doctor.patients.patients') !!}',
                                        columns: [
                                            {data:'patient_number'},
                                            { data: 'full_name' },
                                            { data: 'dob' },
                                            { data: 'gender', render: function(data){ return data == 'M' ? 'ذكر' : 'أنثى'; }},
                                            { data: 'contact_number' },
                                            { data: 'active', render: function(data){ return data == 1 ? 'مفعل' : 'غير مفعل'; }},
                                            { data: 'created_at' },
                                            { data: 'edit' },
                                    {data:'sendWhatsApp'},
                                            { data: 'changeStatus' },
                                            { data: 'show' }, // new column for patient file button
                                        ],
                                        dom: 'Blfrtip',
                                        buttons: [
                                            // { extend: 'copyHtml5', text: 'نسخ' },
                                            { extend: 'excelHtml5', text: 'excel تصدير كـ' },
                                            { extend: 'colvis', text: 'الأعمدة' },
                                        ],
                                    });
                                });
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
