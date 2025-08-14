@extends('doctor.app')
@section('title','الملف الشخصي')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content card">
            <div class="card-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>اسم الطبيب</label></div>
                            <div class="col-xs-7">{{ $user->fullname }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>اسم المستخدم</label></div>
                            <div class="col-xs-7">{{ $user->username }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>البريد الإلكتروني</label></div>
                            <div class="col-xs-7">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>رقم الهاتف</label></div>
                            <div class="col-xs-7">{{ $user->phonenumber }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>التخصص</label></div>
                            <div class="col-xs-7">{{ $user->specializations ? $user->specializations->name : '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>العيادات</label></div>
                            <div class="col-xs-7">
                                @if($user->clinics && $user->clinics->count())
                                    {{ $user->clinics->pluck('name')->implode(', ') }}
                                @else
                                    لا يوجد
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>الحالة</label></div>
                            <div class="col-xs-7">{{ $user->active ? 'مفعل' : 'غير مفعل' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>تاريخ الإنشاء</label></div>
                            <div class="col-xs-7">{{ $user->created_at }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>السيرة الذاتية</label></div>
                            <div class="col-xs-7">
                                @if($user->cv)
                                    <a href="{{ asset('storage/'.$user->cv) }}" target="_blank">عرض السيرة الذاتية</a>
                                @else
                                    لا يوجد
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-5"><label>الصورة</label></div>
                            <div class="col-xs-7">
                                @if($user->image)
                                    <img src="{{ asset('storage/'.$user->image) }}" alt="صورة الطبيب" style="max-width:100px;">
                                @else
                                    لا يوجد
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection