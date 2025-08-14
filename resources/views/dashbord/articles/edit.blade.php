@extends('layouts.app')

@section('content')
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
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
    function previewImage(event) {
        const input = event.target, preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
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
            <h4 class="box-title">
                <a href="{{ route('articles') }}">المقالات</a> / تعديل المقال
            </h4>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box-content">
            <form action="{{ route('articles/update', encrypt($article->id)) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">عنوان المقال</label>
                    <input type="text" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $article->title) }}" required>
                    @error('title')
                        <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">محتوى المقال</label>
                    <textarea name="content" id="content"
                        class="form-control @error('content') is-invalid @enderror"
                        rows="5" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الصورة الحالية</label><br>
                    <img id="imagePreview"
                        src="{{ asset('images/articles/' . $article->bkimage) }}"
                        alt="معاينة الصورة"
                        style="display: block; max-width: 100%; height: auto; margin-bottom:10px;">
                </div>

                <div class="form-group">
                    <label for="image">تغيير صورة المقال</label>
                    <input type="file" name="image" id="image"
                        class="form-control @error('image') is-invalid @enderror"
                        accept="image/*" onchange="previewImage(event)">
                    @error('image')
                        <span class="invalid-feedback" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
