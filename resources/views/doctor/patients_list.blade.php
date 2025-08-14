@extends('doctor.app')

@section('content')
@section('title', 'الإستفسارات')
<div class="row small-spacing">
    <div class="col-md-12">
       <div class="box-content">
                <h4 class="box-title"><a href="{{ route('doctor.patients') }}">الإستفسارات</a> </h4>
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
                                
                                
                                <th></th>
                              
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
                                        ajax: '{!! route('doctor.patients.patients.lists') !!}',
                                        columns: [
                                            { data: 'patient_number' },
                                            { data: 'full_name' },
                                            
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
