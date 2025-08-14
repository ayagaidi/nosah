@extends('layouts.app')
@section('title','تعديل محتوى الصفحة الرئيسية')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('homecontent.index') }}">محتوى الصفحة الرئيسية</a>/تعديل محتوى</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form action="{{ route('homecontent.update', $homecontent->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="clinics_title">عنوان العيادات</label>
                    <input type="text" name="clinics_title" class="form-control" value="{{ $homecontent->clinics_title }}" required>
                </div>
                <div class="form-group">
                    <label for="clinics_text">نص العيادات</label>
                    <textarea name="clinics_text" class="form-control" rows="3" required>{{ $homecontent->clinics_text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="inbody_title">عنوان أجهزة الInBody</label>
                    <input type="text" name="inbody_title" class="form-control" value="{{ $homecontent->inbody_title }}" required>
                </div>
                <div class="form-group">
                    <label for="inbody_text">نص أجهزة الInBody</label>
                    <textarea name="inbody_text" class="form-control" rows="3" required>{{ $homecontent->inbody_text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="banner_title">عنوان البانر</label>
                    <input type="text" name="banner_title" class="form-control" value="{{ $homecontent->banner_title }}" required>
                </div>
                <div class="form-group">
                    <label for="banner_text">نص البانر</label>
                    <textarea name="banner_text" class="form-control" rows="3" required>{{ $homecontent->banner_text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="video_url">رابط الفيديو (اختياري)</label>
                    <input type="text" name="video_url" class="form-control" value="{{ $homecontent->video_url ?? '' }}" placeholder="مثال: https://www.youtube.com/watch?v=xxxxxx">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
