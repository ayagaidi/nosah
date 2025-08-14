@extends('app')
@section('title', 'مقالات')

@section('content')




    <div class="inner-welcome  pt85 bg4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="title">
                        <h1>مقالات</h1>
                    </div>
                    <div class="bread-crumb text-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('/')}}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">مقالات</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="blog-area blog2 section-padding inner-bg ">
        <div class="container">
          <div class="row mb30">
            <div class="col-lg-8">
              <div class="blogs mt-sm-60">

                @foreach($articals as $artical)
                <div class="single-blog">
                  <div class="blog-img blog-img-big">
                    <img src="{{ asset('images/articles/' . $artical->bkimage) }}" alt="">
                    <div class="blog-date">
                      <h2>
                          {{ $artical->created_at->format('d') }}
                          <span>{{ $artical->created_at->locale('ar')->translatedFormat('F') }}</span>
                      </h2>
                    </div>
                  </div>
                  <div class="blog-content">
                    <a href="{{ route('article.show', $artical->id) }}">{{ $artical->title}}</a>
                    <ul>
                      <li><a href="#">{{ $artical->created_at}}</a></li>
                    </ul>
                    <div class="blog-text my-3">
                      <p>
                          {{ \Illuminate\Support\Str::limit(strip_tags($artical->content), 200) }}
                              @if(Str::length(strip_tags($artical->content)) > 200)
                              <a href="{{ route('article.show', $artical->id) }}">عرض المزيد</a>
                          @endif
                      </p>
                    </div>
                    
                  </div>
                </div>
               @endforeach
              
              </div>
              <div class="col-12 text-center mt-4">
                {{ $articals->links() }}
            </div>
            </div>
            <div class="col-lg-4">
              <div class="blog-sidebar  mr-lg-40">
                <div class="widget widget-search mb60">
                  <h3>بحث</h3>
                  <div class="search-from">
                      <input type="search" id="searchInput" class="form-control" placeholder="ابحث في العنوان أو المحتوى">
                  </div>
                </div>
             
                <div class="widget recent-posts mb60">
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


