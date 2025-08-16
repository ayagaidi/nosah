@extends('app')
@section('title', 'الرئيسية')

@section('content')

<!--====== Welcome Start ======-->
<div class="hero-area flex-lg-middle pt85">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="title xss-text-center" data-aos="fade-right" data-aos-offset="300"
                    data-aos-easing="ease-in-sine" data-aos-duration="1000">
                    <p>{!! $whoweare->content !!}</p>

                    <!-- Video Link -->
                    <a href="javascript:void(0);"
                       class="cbtn btn-one effect6 open-video-dialog"
                       data-url="{{ $home->video_url }}">
                        Watch Video <i class="fas fa-play"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-lg-right">
                <div class="hero-soft2" data-aos="fade-left" data-aos-offset="300"
                    data-aos-easing="ease-in-sine" data-aos-duration="1000" data-aos-delay="500">
                    <img src="{{ asset('theme/assets/img/bg/hero.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="hero-3-shape">
        <img src="{{ asset('theme/assets/img/bg/3shape1.svg') }}" alt="">
    </div>
</div>
<!--====== Welcome End ======-->

<!--====== Feature Start ======-->
<div class="feature section-padding o-hidden">
    <div class="container">
        <div class="row align-items-center">
            <a href="{{ route('clinic') }}" class="col-lg-6 d-none d-lg-block">
                <div class="feature-img feature-3-1-bg" data-aos="fade-up" data-aos-offset="300"
                    data-aos-easing="ease-in-sine">
                    <img src="{{ asset('theme/clinic.png') }}" alt="">
                </div>
            </a>
            <div class="col-lg-5 offset-lg-1">
                <div class="heading" data-aos="fade-left" data-aos-offset="300"
                    data-aos-easing="ease-in-sine" data-aos-duration="500" data-aos-delay="500">
                    <h2>{{ $home->clinics_title }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($home->clinics_text) }}</p>
                </div>
                <a href="{{ route('clinic') }}">عرض المزيد</a>
            </div>
            <div class="col-lg-6 d-lg-none">
                <div class="feature-img" data-aos="fade-up" data-aos-offset="300"
                    data-aos-easing="ease-in-sine">
                    <img src="{{ asset('theme/assets/img/feature/feature3-1.svg') }}" alt="">
                </div>
            </div>
        </div>

        <div class="space-100"></div>

        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="heading" data-aos="fade-up" data-aos-offset="300"
                    data-aos-easing="ease-in-sine">
                    <h2>{{ $home->inbody_title }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($home->inbody_text) }}</p>
                </div>
                <a href="{{ route('inbody') }}">عرض المزيد</a>
            </div>
            <a href="{{ route('inbody') }}" class="col-lg-7">
                <div class="feature-img feature-3-2-bg text-right" data-aos="fade-left" data-aos-offset="300"
                    data-aos-easing="ease-in-sine" data-aos-duration="500" data-aos-delay="500">
                    <img src="{{ asset('theme/inboday.png') }}" alt="">
                </div>
            </a>
        </div>
    </div>
</div>
<!--====== Feature End ======-->

<!--====== Trial Start ======-->
<div class="trial bg3 white-element section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto text-center" data-aos="fade-down" data-aos-offset="300"
                data-aos-easing="ease-in-sine" data-aos-duration="500" data-aos-delay="500">
                <div class="heading heading-white">
                    <h2>{{ $home->banner_title }}</h2>
                    <p>{{ $home->banner_text }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--====== Trial End ======-->

<!--====== Blog Start ======-->
<div class="blog-area blog3 section-padding2">
    <div class="container">
        <div class="row">
            @foreach ($articles as $artical)
            <div class="col-lg-6">
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
                        <a href="{{ route('article.show', $artical->id) }}">{{ $artical->title }}</a>
                        <ul>
                            <li><a href="{{ route('article.show', $artical->id) }}">{{ $artical->created_at }}</a></li>
                        </ul>
                        <div class="blog-text my-3">
                            <p>
                                {{ \Illuminate\Support\Str::limit(strip_tags($artical->content), 200) }}
                                @if(Str::length(strip_tags($artical->content)) > 200)
                                    <a href="{{ route('article.show', $artical->id) }}">اقرأ المزيد</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--====== Blog End ======-->

<!--====== Video Modal ======-->
<div id="videoModal" class="video-modal" style="display:none;">
    <div class="video-content">
        <span class="close-video" onclick="closeVideoModal()">&times;</span>
        <iframe id="videoFrame" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<!--====== Video Modal Styles ======-->
<style>
.video-modal {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.video-content {
    position: relative;
    background: #000;
    padding: 10px;
    border-radius: 10px;
    max-width: 90%;
    max-height: 80%;
}
.close-video {
    position: absolute;
    top: -10px;
    right: -10px;
    font-size: 30px;
    color: white;
    cursor: pointer;
}
#videoFrame {
    border: none;
    width: 560px;
    height: 315px;
}
</style>

<!--====== Video Modal Script ======-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const videoLinks = document.querySelectorAll('.open-video-dialog');

    videoLinks.forEach(link => {
        link.addEventListener('click', function () {
            const videoUrl = this.getAttribute('data-url');
            let embedUrl = '';

            // Convert to embed format
            if (videoUrl.includes('watch?v=')) {
                const videoId = videoUrl.split('watch?v=')[1].split('&')[0];
                embedUrl = 'https://www.youtube.com/embed/' + videoId;
            } else if (videoUrl.includes('youtu.be/')) {
                const videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                embedUrl = 'https://www.youtube.com/embed/' + videoId;
            } else if (videoUrl.includes('youtube.com/embed/')) {
                embedUrl = videoUrl; // already in embed format
            } else {
                alert('Unsupported video format');
                return;
            }

            document.getElementById('videoFrame').src = embedUrl + '?autoplay=1';
            document.getElementById('videoModal').style.display = 'flex';
        });
    });
});

function closeVideoModal() {
    document.getElementById('videoFrame').src = '';
    document.getElementById('videoModal').style.display = 'none';
}
</script>

@endsection
