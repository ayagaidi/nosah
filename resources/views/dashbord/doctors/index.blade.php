@extends('layouts.app')
@section('title', 'الأطباء')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a type="button" href="{{ route('doctors/create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">إضافة طبيب</a>
            </div>
        </div>
        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض الأطباء</h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable2"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom"
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>اسم الطبيب</th>
                                    <th>اسم المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>التخصص</th>
                                    <th>العيادات</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>تعديل</th>
                                    <th>تغيير الحالة</th>
                                    <th>عرض</th>

                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    $(document).ready(function() {
                                        $('#datatable2').dataTable({
                                            "language": {
                                                "url": "../Arabic.json"
                                            },
                                            "lengthMenu": [5, 10],
                                            "bLengthChange": true,
                                            serverSide: false,
                                            paging: true,
                                            searching: true,
                                            ordering: true,
                                            ajax: '{!! route('doctors/doctors') !!}',
                                            columns: [{
                                                    data: 'fullname',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'username',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'email',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'phonenumber',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'specializations.name',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'clinics', // Add clinics data
                                                    render: function(data) {
                                                        if (data && data.length > 0) {
                                                            return data.map(clinic => clinic.name).join(', ');
                                                        }
                                                        return 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'active',
                                                    render: function(data) {
                                                        return data == 1 ? 'مفعل' : 'غير مفعل';
                                                    }
                                                },
                                                {
                                                    data: 'created_at',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'edit'
                                                },
                                                {
                                                    data: 'changeStatus'
                                                },
                                                {
                                                    data: null,
                                                    render: function(data, type, row) {
                                                        var id = row.id ? row.id : '';
                                                        var url = '';
                                                        if (id) {
                                                            url = "{{ route('doctors/view', ':id') }}".replace(':id', id);
                                                        }
                                                        return id ? '<a href="' + url +
                                                            '" class="" title="عرض"><i class="fa fa-file"></i></a>' : '';
                                                    }
                                                },
                                                {
                                                    data: null,
                                                    render: function(data, type, row) {
                                                        var id = row.id ? row.id : '';
                                                        var url = '';
                                                        if (id) {
                                                            url = "{{ route('doctors/sendLogin', ':id') }}".replace(':id', id);
                                                        }
                                                        return id ? '<a target="_blank" href="' + url +
                                                            '" class="" title="إرسال بيانات الدخول"><i class="fa fa-envelope"></i></a>' :
                                                            '';
                                                    }
                                                },
                                                {
                                                    data: null,
                                                    render: function(data, type, row) {
                                                        var id = row.id ? row.id : '';
                                                        var url = '';
                                                        if (id) {
                                                            url = "{{ route('doctors/sendLoginWhatsApp', ':id') }}".replace(':id', id);
                                                        }
                                                        return id ? '<a target="_blank" href="' + url +
                                                            '" class="" title="إرسال بيانات الدخول عبر واتساب"><i class="fa fa-whatsapp"></i></a>' :
                                                            '';
                                                    }
                                                },

                                            ],
                                            dom: 'Blfrtip',
                                            buttons: [
                                                // { extend: 'copyHtml5', text: 'نسخ' },
                                                {
                                                    extend: 'excelHtml5',
                                                    text: 'excel تصدير كـ'
                                                },
                                                {
                                                    extend: 'colvis',
                                                    text: 'الأعمدة'
                                                },
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
