@extends('layouts.app')
@section('title','إضافة الحمية الغذائية')

@section('content')
<link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#text').summernote({
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
            <h4 class="box-title"><a href="{{ route('diets.index') }}">الحمية الغذائية</a>/إضافة محتوى</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form action="{{ route('diets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">العنوان</label>
                    <input type="text"  name="title" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')
                    <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="text">النص</label>
                    <textarea name="text"  id="text" class="form-control @error('text') is-invalid @enderror" rows="5" required></textarea>
                    @error('text')
                    <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">الصورة (*)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                    <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
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
