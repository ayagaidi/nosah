@extends('layouts.app')
@section('title','العيادات')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <a type="button" href="{{ route('clinics/create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">إضافة عيادة</a>
        </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">عرض العيادات</h4>
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="datatable1" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th>اسم العيادة</th>
                                <th>العنوان</th>
                                <th>رقم الهاتف</th>
                                <th>الموقع</th>
                                <th>تاريخ الإنشاء</th>
                                <th></th>
                                <th></th>
                                <th>الأطباء والتخصصات</th>
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
                                        ajax: '{!! route('clinics/clinics') !!}',
                                        columns: [
                                            { 
                                                data: 'name',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'address',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'phone_number',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'url_location',
                                                render: function(data) {
                                                    return data ? `<a href="${data}" target="_blank"><i class="fa fa-map-marker" style="font-size: 18px; color: #007bff;"></i></a>` : 'لا يوجد';
                                                }
                                            },
                                            { 
                                                data: 'created_at',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            },
                                            { data: 'edit' },
                                            { data: 'changeStatus' },
                                            { 
                                                data: 'viewDoctors',
                                                render: function(data) {
                                                    return data ? data : 'لا يوجد';
                                                }
                                            }
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
