@extends('doctor.app')
@section('title', 'تفاصيل الخطة الغذائية')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('doctor.diet_plans.index', $patient->id) }}">خطط المريض الغذائية</a> /  تفاصيل الخطة الغذائية للمريض {{ $patient->patient_number }}
            </h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content card">
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>تاريخ الخطة</th>
                                <td>{{ $plan->date }}</td>
                            </tr>
                            <tr>
                                <th>نوع الوجبة</th>
                                <td>{{ $plan->meal_type }}</td>
                            </tr>
                            <tr>
                                <th>فئة الطعام</th>
                                <td>{{ $plan->food_category }}</td>
                            </tr>
                            <tr>
                                <th>العنصر الغذائي</th>
                                <td>{{ $plan->food_item }}</td>
                            </tr>
                            <tr>
                                <th>حجم الحصة</th>
                                <td>{{ $plan->portion_size }}</td>
                            </tr>
                            <tr>
                                <th>السعرات</th>
                                <td>{{ $plan->calories }}</td>
                            </tr>
                            <tr>
                                <th>الكربوهيدرات (غ)</th>
                                <td>{{ $plan->carbs }}</td>
                            </tr>
                            <tr>
                                <th>البروتين (غ)</th>
                                <td>{{ $plan->protein }}</td>
                            </tr>
                            <tr>
                                <th>الدهون (غ)</th>
                                <td>{{ $plan->fat }}</td>
                            </tr>
                            <tr>
                                <th>الألياف (غ)</th>
                                <td>{{ $plan->fiber }}</td>
                            </tr>
                            <tr>
                                <th>السوائل</th>
                                <td>{{ $plan->fluid_intake }}</td>
                            </tr>
                            <tr>
                                <th>المكملات</th>
                                <td>{{ $plan->supplements }}</td>
                            </tr>
                            <tr>
                                <th>تعليمات خاصة</th>
                                <td>{{ $plan->special_instructions }}</td>
                            </tr>
                            <tr>
                                <th>موانع أو حساسية</th>
                                <td>{{ $plan->dietary_restrictions }}</td>
                            </tr>
                            <tr>
                                <th>ملاحظات الالتزام</th>
                                <td>{{ $plan->compliance_notes }}</td>
                            </tr>
                            <tr>
                                <th>اسم الطبيب</th>
                                <td>{{ $doctor->fullname ?? $plan->prescribed_by }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ إصدار الخطة</th>
                                <td>{{ $plan->date_prescribed }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('doctor.diet_plans.index', $patient->id) }}"  ><i  class="fa  fa-arrow-left"> </i>رجوع</a>
                    <a href="{{ route('doctor.diet_plans.edit', [$patient->id, $plan->id]) }}" style="color: #f97424;"><i  class="fa  fa-edit"> </i>تعديل</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
