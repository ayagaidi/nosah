@extends('layouts.app')
@section('title','تعديل معلومات الاتصال')
@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('contactinfos') }}">معلومات الاتصال</a>/تعديل معلومات الاتصال
            </h4>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box-content">
            <form action="{{ route('contactinfos/update', encrypt($info->id)) }}" method="POST">
              @csrf 
              <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text"
                       name="phonenumber"
                       class="form-control @error('phonenumber') is-invalid @enderror"
                       value="{{ old('phonenumber', $info->phonenumber) }}">
                @error('phonenumber')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $info->email) }}">
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="d-flex justify-content-end">
                <a href="{{ route('contactinfos') }}" class="btn btn-secondary me-2">إلغاء</a>
                <button type="submit" class="btn btn-primary">تحديث</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection