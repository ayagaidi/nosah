@extends('layouts.app')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">من نحن</h4>
            @if($whoweare)
                <div class="">
                    <p>{!! $whoweare->content !!}</p>
               
                </div>
                <a href="{{ route('whoweare/edit', $whoweare->id) }}" class="btn btn-primary btn-bordered waves-effect waves-light">تعديل</a>
            @else
                <div class="alert alert-warning text-center">
                    <p>لا يوجد محتوى حاليًا.</p>
                </div>

                <div style="text-align: left;">
                    <a href="{{ route('whoweare/create') }}" class="btn btn-success btn-bordered waves-effect waves-light">إضافة محتوى</a>

                </div>
            @endif
        </div>
    </div>
</div>
@endsection
