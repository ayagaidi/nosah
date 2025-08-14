@extends('layouts.app')
@section('title','محتوى الصفحة الرئيسية')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">محتوى الصفحة الرئيسية</h4>
            @if($homecontent)
                <div class="alert ">
                    <h5>{{ $homecontent->clinics_title }}</h5>
                    <p>{!! $homecontent->clinics_text !!}</p>
                    <hr>
                    <h5>{{ $homecontent->inbody_title }}</h5>
                    <p>{!! $homecontent->inbody_text !!}</p>
                    <hr>
                    <h5>{{ $homecontent->banner_title }}</h5>
                    <p>{!! $homecontent->banner_text !!}</p>
                    @if($homecontent->video_url)
                        <hr>
                        <h5>الفيديو التعريفي</h5>
                        <div class="embed-responsive embed-responsive-16by9" style="max-width: 600px;">
                            <iframe class="embed-responsive-item" src="{{ Str::contains($homecontent->video_url, 'youtube.com') ? preg_replace('/watch\?v=/', 'embed/', $homecontent->video_url) : $homecontent->video_url }}" allowfullscreen style="width:100%;min-height:300px;border:0;"></iframe>
                        </div>
                    @endif
                </div>
                <a href="{{ route('homecontent.edit', $homecontent->id) }}" class="btn btn-primary">تعديل</a>
            @else
                <div class="alert alert-warning text-center">
                    <p>لا يوجد محتوى حاليًا.</p>
                </div>
                <a href="{{ route('homecontent.create') }}" class="btn btn-success">إضافة محتوى</a>
            @endif
        </div>
    </div>
</div>
@endsection
