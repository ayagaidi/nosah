@extends('app')
@section('title', $diet->title)

@section('content')
    <div class="inner-welcome pt85 bg4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="title">
                        <h1>{{ $diet->title }}</h1>
                    </div>
                    <div class="bread-crumb text-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('diet') }}">الحمية الغدائية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $diet->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-area blog2 section-padding inner-bg">
        <div class="container">
            <div class="row mb30">
                <div class="col-lg-8">
                    <div class="single-blog">
                        <div class="blog-img blog-img-big">
                            @if($diet->image)
                                <img src="{{ asset('images/diets/' . $diet->image) }}" alt="{{ $diet->title }}">
                            @endif
                            <div class="blog-date">
                                <h2>
                                    {{ $diet->created_at->format('d') }}
                                    <span>{{ $diet->created_at->locale('ar')->translatedFormat('F') }}</span>
                                </h2>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-text my-3">
                                {!! $diet->text !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                      <div class="widget recent-posts mb60">
                  <h3>المقالات الأخيرة</h3>
                  @foreach($diets->take(5) as $dietss)

                  <div class="single-recent">
                    <div class="recent-post-thumbnails">
                        <img src="{{ asset('images/diets/' . $dietss->image) }}" alt="">

                      
                    </div>
                    <p>{{ $dietss->created_at->format('d/m/Y') }}</p>
                    <a href="{{ route('diet.show', $dietss->id) }}">{{ $dietss->title}}</a>
                  </div>
                  
                  @endforeach

                 
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#searchInput').on('keyup', function() {
                var term = $(this).val().toLowerCase();
                $('.single-blog').each(function() {
                    var title   = $(this).find('.blog-content a').text().toLowerCase();
                    var content = $(this).find('.blog-text').text().toLowerCase();
                    $(this).toggle(title.includes(term) || content.includes(term));
                });
            });
        });
    </script>
@endsection
