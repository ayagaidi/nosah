@extends('layouts.app')
@section('title','إضافة معلومات الاتصال')
@section('content')
<div class="row small-spacing">
  <div class="col-md-12">
    <div class="box-content">
      <h4 class="box-title">
        <a href="{{ route('contactinfos') }}">معلومات الاتصال</a>/إضافة معلومات الاتصال
      </h4>
    </div>
  </div>

  <div class="col-md-12">
    <div class="box-content">
      <form method="POST" action="{{ route('contactinfos/store') }}">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="phonenumber" class="control-label">رقم الهاتف</label>
              <input type="text"
                     name="phonenumber"
                     id="phonenumber"
                     class="form-control @error('phonenumber') is-invalid @enderror"
                     value="{{ old('phonenumber') }}"
                     placeholder="رقم الهاتف">
              @error('phonenumber')
              <span class="invalid-feedback" style="color: red">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="email" class="control-label">البريد الإلكتروني</label>
              <input type="email"
                     name="email"
                     id="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email') }}"
                     placeholder="البريد الإلكتروني">
              @error('email')
              <span class="invalid-feedback" style="color: red">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary waves-effect waves-light">حفظ</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection