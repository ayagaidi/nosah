@extends('layouts.app')

@section('title','إضافة مقال')

@section('content')
<link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 300, // Set editor height
            lang: 'ar-AR', // Set language to Arabic (if needed, include the language file)
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

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('articles') }}">المقالات</a>/إضافة مقال</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form action="{{ route('articles/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="control-label">عنوان المقال</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="عنوان المقال" required>
                            @error('title')
                            <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="control-label">محتوى المقال</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="محتوى المقال" required>{{ old('content') }}</textarea>
                    @error('content')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image" class="control-label">صورة المقال</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
                    @error('image')
                    <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <img id="imagePreview" style="height: 200px" src="#" alt="معاينة الصورة" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">إضافة مقال</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
