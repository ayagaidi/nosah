@extends('layouts.app')
@section('title','تعديل عيادة')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('clinics') }}">العيادات</a>/تعديل عيادة</h4>
        </div>
    </div>
    <div class="col-md-8">>
        <div class="box-content">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">اسم العيادة</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $clinic->name }}" placeholder="اسم العيادة">
                            @error('name')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cities_id" class="control-label">المدينة</label>
                            <select name="cities_id" class="form-control @error('cities_id') is-invalid @enderror">
                                <option value="">اختر المدينة</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $clinic->cities_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('cities_id')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="control-label">العنوان</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $clinic->address }}" placeholder="العنوان">
                            @error('address')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number" class="control-label">رقم الهاتف</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ $clinic->phone_number }}" placeholder="رقم الهاتف">
                            @error('phone_number')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="url_location" class="control-label">رابط الموقع</label>
                    <input type="text" name="url_location" class="form-control @error('url_location') is-invalid @enderror" value="{{ $clinic->url_location }}" placeholder="رابط الموقع">
                    @error('url_location')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل عيادة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
