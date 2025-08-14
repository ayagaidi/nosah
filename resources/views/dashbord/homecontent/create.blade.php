@extends('layouts.app')
@section('title','إضافة محتوى الصفحة الرئيسية')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('homecontent.index') }}">محتوى الصفحة الرئيسية</a>/إضافة محتوى</h4>
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
            <form action="{{ route('homecontent.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="clinics_title">عنوان العيادات</label>
                    <input type="text" name="clinics_title" class="form-control @error('clinics_title') is-invalid @enderror" required>
                    @error('clinics_title')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="clinics_text">نص العيادات</label>
                    <textarea name="clinics_text" class="form-control @error('clinics_text') is-invalid @enderror" rows="3" required></textarea>
                    @error('clinics_text')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inbody_title">عنوان أجهزة الInBody</label>
                    <input type="text" name="inbody_title" class="form-control @error('inbody_title') is-invalid @enderror" required>
                    @error('inbody_title')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inbody_text">نص أجهزة الInBody</label>
                    <textarea name="inbody_text" class="form-control @error('inbody_text') is-invalid @enderror" rows="3" required></textarea>
                    @error('inbody_text')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="banner_title">عنوان البانر</label>
                    <input type="text" name="banner_title" class="form-control @error('banner_title') is-invalid @enderror" required>
                    @error('banner_title')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="banner_text">نص البانر</label>
                    <textarea name="banner_text" class="form-control @error('banner_text') is-invalid @enderror" rows="3" required></textarea>
                    @error('banner_text')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="video_url">رابط الفيديو (اختياري)</label>
                    <input type="text" name="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="مثال: https://www.youtube.com/watch?v=xxxxxx">
                    @error('video_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
