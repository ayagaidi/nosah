@extends('layouts.app')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('whoweare') }}">من نحن</a>/إضافة محتوى</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form action="{{ route('whoweare/store') }}" method="POST">
                @csrf
                <div class="form-group" style="display: flex; align-items: flex-start; gap: 20px;">
                    <div style="flex: 2; text-align: left;">
                        <label for="content" class="control-label">المحتوى</label>
                        <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5" required></textarea>
                        @error('content')
                        <span class="invalid-feedback" style="color: red" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success waves-effect waves-light">حفظ</button>
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
