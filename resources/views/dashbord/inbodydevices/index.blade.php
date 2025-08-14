@extends('layouts.app')
@section('title','أجهزة الInBody')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <a type="button" href="{{ route('inbodydevices/create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">إضافة جهاز</a>
        </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">عرض أجهزة الInBody</h4>
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="datatable1" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th>اسم المكان</th>
                                <th>المدينة</th>
                                <th>موديل الجهاز</th>
                                <th>الرابط</th>
                                <th>الحالة</th> <!-- Added column for device status -->
                                <th></th>
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
                                        ajax: '{!! route('inbodydevices/inbodydevices') !!}',
                                        columns: [
                                            { 
                                                data: 'place_name',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'cities.name',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'device_model',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'url',
                                                render: function(data) {
                                                    return data ? `<a href="${data}" target="_blank"><i class="fa fa-link" style="font-size: 18px; color: #007bff;"></i></a>` : 'لا يوجد';
                                                }
                                            },
                                            {
                        data: 'active', 
              render: function(data) { 
                if(data==1) {
                  return 'الجهاز مفعل <i class="fa fa-circle" style="color:#2be71b;;" aria-hidden="true"></i>' 
                }
                else {
                  return 'الجهاز معطل <i class="fa fa-circle" style="color:#e71b1b;;" aria-hidden="true"></i>'
                }
                
}},
                                            { data: 'edit' },
                                            { data: 'changeStatus' },
                                        ],
                                        dom: 'Blfrtip',
                                        buttons: [
                                            { extend: 'copyHtml5', text: 'نسخ' },
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
