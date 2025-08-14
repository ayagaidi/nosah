@extends('layouts.app')
@section('title','إضافة جهاز InBody')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('inbodydevices') }}">أجهزة الInBody</a>/إضافة جهاز</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="place_name" class="control-label">اسم المكان</label>
                            <input type="text" name="place_name" class="form-control @error('place_name') is-invalid @enderror" value="{{ old('place_name') }}" placeholder="اسم المكان">
                            @error('place_name')
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
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('cities_id')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="device_model" class="control-label">موديل الجهاز</label>
                    <input type="text" name="device_model" class="form-control @error('device_model') is-invalid @enderror" value="{{ old('device_model') }}" placeholder="موديل الجهاز">
                    @error('device_model')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="url" class="control-label">الرابط</label>
                    <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" placeholder="الرابط">
                    @error('url')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">إضافة جهاز</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
