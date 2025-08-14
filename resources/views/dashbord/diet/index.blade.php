@extends('layouts.app')
@section('title', 'الحمية الغذائية')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a type="button" href="{{ route('diets.create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">إضافة حمية جديدة</a>
            </div>
        </div>
        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض الحميات الغذائية</h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable-diet" class="table table-bordered table-hover table-custom"
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>النص</th>
                                    <th>الصورة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>نشر</th>

                                    <th>تعديل</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                var table = $('#datatable-diet').dataTable({
                                    "language": {
                                        "url": "../Arabic.json"
                                    },
                                    "lengthMenu": [5, 10],
                                    "bLengthChange": true,
                                    serverSide: false,
                                    paging: true,
                                    searching: true,
                                    ordering: true,
                                    ajax: '{{ route('diets/dataa') }}',
                                    columns: [{
                                            data: 'title',
                                            render: function(data) {
                                                return data ? data : 'لا يوجد';
                                            }
                                        },
                                        {
                                            data: 'text',
                                            render: function(data) {
                                                return data ? $('<div>').html(data).text().substring(0, 100) :
                                                'لا يوجد';
                                            }
                                        },
                                        {
                                            data: 'image',

                                        },
                                        {
                                            data: 'created_at',
                                            render: function(data) {
                                                return data ? data : 'لا يوجد';
                                            }
                                        },
                                        {
                                            data: 'publish'
                                        },
                                        {
                                            data: 'edit'
                                        }
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

                                // Toggle publish/unpublish for diet
                                $('#datatable-diet').on('click', '.toggle-publish-diet', function() {
                                    var btn = $(this);
                                    var id = btn.data('id');
                                    $.ajax({
                                        url: '{{ route('diets.togglePublish') }}',
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
