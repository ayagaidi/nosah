@extends('layouts.app')
@section('title','تعديل طبيب')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('doctorss') }}">الأطباء</a>/تعديل طبيب</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname" class="control-label">اسم الطبيب</label>
                            <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{ $doctor->fullname }}" placeholder="اسم الطبيب">
                            @error('fullname')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="control-label">اسم المستخدم</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ $doctor->username }}" placeholder="اسم المستخدم">
                            @error('username')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="control-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $doctor->email }}" placeholder="البريد الإلكتروني">
                            @error('email')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phonenumber" class="control-label">رقم الهاتف</label>
                            <input type="text" name="phonenumber" maxlength="10" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ $doctor->phonenumber }}" placeholder="رقم الهاتف">
                            @error('phonenumber')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="specializations_id" class="control-label">التخصص</label>
                    <select name="specializations_id" class="form-control @error('specializations_id') is-invalid @enderror">
                        <option value="">اختر التخصص</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization->id }}" {{ $doctor->specializations_id == $specialization->id ? 'selected' : '' }}>
                                {{ $specialization->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('specializations_id')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="clinics" class="control-label">العيادات</label>
                    <div>
                        @foreach($clinics as $clinic)
                            <div class="form-check">
                                <input type="checkbox" name="clinics[]" value="{{ $clinic->id }}" class="form-check-input" id="clinic-{{ $clinic->id }}" 
                                    {{ $doctor->clinics ? (in_array($clinic->id, $doctor->clinics->pluck('id')->toArray()) ? 'checked' : '') : '' }}>
                                <label class="form-check-label" for="clinic-{{ $clinic->id }}">{{ $clinic->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('clinics')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cv" class="control-label">السيرة الذاتية (CV)</label>
                    @if($doctor->cv)
                        <p>ملف السيرة الذاتية الحالي: <a href="{{ asset('doctors/cv/' . $doctor->cv) }}" target="_blank">عرض السيرة الذاتية</a></p>
                    @else
                        <p>لا يوجد ملف سيرة ذاتية مرفق.</p>
                    @endif
                    <input type="file" name="cv" class="form-control @error('cv') is-invalid @enderror" accept=".pdf,.doc,.docx">
                    @error('cv')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل طبيب</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
