@extends('app')
@section('title', $article->title)

@section('content')
<div class="inner-welcome pt85 bg4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="title">
                    <h1>{{ $article->title }}</h1>
                </div>
                <div class="bread-crumb text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('articals') }}">مقالات</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blog-area blog2 section-padding inner-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="single-blog">
                    @if($article->bkimage)
                    <div class="blog-img blog-img-big">
                        <img src="{{ asset('images/articles/' . $article->bkimage) }}" alt="{{ $article->title }}">
                    </div>
                    @endif
                    <div class="blog-content mt-3">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><strong>الكاتب:</strong> {{ $article->users ? $article->users->name : $article->author }}</li>
                            <li class="list-inline-item"><strong>تاريخ النشر:</strong> {{ $article->created_at->format('d/m/Y') }}</li>
                        </ul>
                        <div class="blog-text">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>
                {{-- <a href="{{ route('articals') }}" class="btn btn-primary mt-4">العودة إلى المقالات</a> --}}
            </div>
                <div class="col-lg-4">
                  <h3>المقالات الأخيرة</h3>
                  @foreach($articals->take(5) as $articalss)

                  <div class="single-recent">
                    <div class="recent-post-thumbnails">
                        <img src="{{ asset('images/articles/' . $articalss->bkimage) }}" alt="">

                      
                    </div>
                    <p>{{ $articalss->created_at->format('d/m/Y') }}</p>
                    <a href="{{ route('article.show', $articalss->id) }}">{{ $articalss->title}}</a>
                  </div>
                  
                  @endforeach

                 
                </div>
        </div>
    </div>
</div>
@endsection
