@extends('layouts.app')
@section('title', 'المقالات')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a type="button" href="{{ route('articles/create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">إضافة مقال جديد</a>
            </div>
        </div>
        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض المقالات</h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom"
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>المؤلف</th>
                                    <th>الصورة</th>

                                    <th>تاريخ الإنشاء</th>
                                    <th>الحالة</th>
                                    <th>نشر/إلغاء نشر</th>
                                    <th>تعديل</th>
                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    $(document).ready(function() {
                                        var table = $('#datatable1').dataTable({
                                            "language": {
                                                "url": "../Arabic.json"
                                            },
                                            "lengthMenu": [5, 10],
                                            "bLengthChange": true,
                                            serverSide: true,
                                            paging: true,
                                            searching: true,
                                            ordering: true,
                                            ajax: '{{ route('articles/data') }}',
                                            columns: [{
                                                    data: 'title',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'users.username',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'image',
                                                    orderable: true,
                                                    searchable: false
                                                }, {
                                                    data: 'created_at',
                                                    render: function(data) {
                                                        if (!data) return 'لا يوجد';
                                                        var d = new Date(data);
                                                        var day = d.getDate(); // 1–31
                                                        var month = d.getMonth() + 1; // 1–12
                                                        var year = d.getFullYear();
                                                        var hour = d.getHours(); // 0–23
                                                        var min = d.getMinutes(); // 0–59
                                                        // pad minutes/hours if needed
                                                        if (hour < 10) hour = '0' + hour;
                                                        if (min < 10) min = '0' + min;
                                                        return day + '/' + month + '/' + year + '، ' + hour + ':' + min;
                                                    }
                                                },
                                                {
                                                    data: 'status',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                                {
                                                    data: 'published',
                                                    orderable: false,
                                                    searchable: false
                                                },
                                                {
                                                    data: 'edit',
                                                    render: function(data) {
                                                        return data ? data : 'لا يوجد';
                                                    }
                                                },
                                            ],
                                            dom: 'Blfrtip',
                                            buttons: [{
                                                    extend: 'copyHtml5',
                                                    text: 'نسخ'
                                                },
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

                                        // Toggle publish/unpublish
                                        $('#datatable1').on('click', '.toggle-publish', function() {
                                            var btn = $(this);
                                            var id = btn.data('id');
                                            $.ajax({
                                                url: '{{ route('articles.togglePublish') }}',
                                                method: 'POST',
                                                data: {
                                                    id: id,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        table.api().ajax.reload(null, false);
                                                    }
                                                }
                                            });
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
