@extends('doctor.app')
@section('title', 'خطط المريض الغذائية')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">
                    <a href="{{ route('doctor.diet_plans.search.form') }}">خطط المريض الغذائية</a> / خطط المريض الغذائية
                    {{ $patient->full_name }}
                </h4>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="box-content">
             <div class="col-md-12">
            <a href="{{ route('doctor.diet_plans.create', $patient->id) }}" class="btn btn-success mb-2">إضافة خطة جديدة</a>
            <a href="{{ route('doctor.diet_plans.search.form') }}" class="btn btn-info mb-2">بحث عن مريض آخر</a>
        
             
            <div class="table-responsive">
                <table id="diet-plans-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>نوع الوجبة</th>
                            <th>فئة الطعام</th>
                            <th>العنصر الغذائي</th>
                            <th>الحجم</th>
                            <th>السعرات</th>
                            <th>الكربوهيدرات</th>
                            <th>البروتين</th>
                            <th>الدهون</th>
                            <th>الألياف</th>
                            <th>السوائل</th>
                            <th>المكملات</th>
                            <th>عرض</th>
                            <th>تعديل</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- سيتم ملء البيانات عبر DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- تأكد من تحميل jQuery و DataTables -->
    <script>
        $(function() {
            $('#diet-plans-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('doctor.diet_plans.ajax', $patient->id) }}',
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'meal_type',
                        name: 'meal_type'
                    },
                    {
                        data: 'food_category',
                        name: 'food_category'
                    },
                    {
                        data: 'food_item',
                        name: 'food_item'
                    },
                    {
                        data: 'portion_size',
                        name: 'portion_size'
                    },
                    {
                        data: 'calories',
                        name: 'calories'
                    },
                    {
                        data: 'carbs',
                        name: 'carbs'
                    },
                    {
                        data: 'protein',
                        name: 'protein'
                    },
                    {
                        data: 'fat',
                        name: 'fat'
                    },
                    {
                        data: 'fiber',
                        name: 'fiber'
                    },
                    {
                        data: 'fluid_intake',
                        name: 'fluid_intake'
                    },
                    {
                        data: 'supplements',
                        name: 'supplements'
                    },
                    {
                        data: 'show',
                        name: 'show',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        orderable: false,
                        searchable: false
                    }
                ],
                "language": {
                    "url": "../../../Arabic.json"
                },
            });
        });
    </script>
@endsection
