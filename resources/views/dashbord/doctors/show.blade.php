@extends('layouts.app')
@section('title', 'عرض الطبيب')

@section('content')
<div class="row small-spacing">
      <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('doctorss') }}">الأطباء</a>/عرض بيانات طبيب</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>الاسم الكامل</th>
                            <td>{{ $doctor->fullname }}</td>
                        </tr>
                        <tr>
                            <th>اسم المستخدم</th>
                            <td>{{ $doctor->username }}</td>
                        </tr>
                        <tr>
                            <th>البريد الإلكتروني</th>
                            <td>{{ $doctor->email }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف</th>
                            <td>{{ $doctor->phonenumber }}</td>
                        </tr>
                        <tr>
                            <th>التخصص</th>
                            <td>{{ $doctor->specializations ? $doctor->specializations->name : 'لا يوجد' }}</td>
                        </tr>
                        <tr>
                            <th>العيادات</th>
                            <td>
                                @if($doctor->clinics && $doctor->clinics->count() > 0)
                                    {{ $doctor->clinics->pluck('name')->join(', ') }}
                                @else
                                    لا يوجد
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>الحالة</th>
                            <td>{{ $doctor->active == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ الإنشاء</th>
                            <td>{{ $doctor->created_at }}</td>
                        </tr>
                        <tr>
                            <th>الصورة</th>
                            <td>
                                @if($doctor->image)
                                    <img src="{{ asset('storage/' . $doctor->image) }}" alt="صورة الطبيب" style="max-width: 150px;">
                                @else
                                    لا يوجد
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>السيرة الذاتية</th>
                            <td>
                                @if($doctor->cv)
                                    <a href="{{ asset('doctors/cv/' . $doctor->cv) }}" target="_blank">عرض السيرة الذاتية</a>
                                @else
                                    لا يوجد
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
