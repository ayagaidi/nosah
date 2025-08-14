@extends('layouts.app')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('whoweare') }}">من نحن</a>/تعديل المحتوى</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form action="{{ route('whoweare/update', $whoweare->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="content" class="control-label">المحتوى</label>
                    <textarea style="height: 100vh" name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{!! $whoweare->content !!}</textarea>
                    @error('content')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 300,
            lang: 'ar-AR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection

