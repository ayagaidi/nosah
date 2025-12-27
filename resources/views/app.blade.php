<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

  <!--====== Meta-data ======-->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--====== Title ======-->
  <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('logo.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nosah-@yield('title')</title>

  <!--====== Favicon Icons css ======-->
  <!--====== FontAwesome Icons css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/plugins/fontawesome.css') }}">
  <!--====== Bootstrap css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/plugins/bootstrap.rtl.min.css') }}">
  <!--====== Nice Select Css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/plugins/nice-select.css') }}">
  <!--====== Caoursel css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/plugins/slick.css') }}">
  <!--====== Aos Animations css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/plugins/aos.css') }}">
  <!--====== Modal video css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/plugins/modal-video.min.css') }}">
  <!--====== Master css ======-->
  <link rel="stylesheet" href="{{ asset('theme/assets/css/master.css') }}">
  <!--====== Local Tajawal Font ======-->
  <link rel="stylesheet" href="{{ asset('cairo.css') }}">



  <!--====== Jquery js ======-->
  <script src="{{ asset('theme/assets/js/plugins/jquery-3.6.3.min.js') }}"></script>
</head>

<body class="theme3 theme-rtl" style="font-family: 'Cairo', sans-serif;">

  <!--====== Preloader Start ======-->
  <div class="preloader">
    <div class="gooey">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!--====== Preloader End ======-->

  <!--====== Header Start ======-->
  <header class="absolute-header">
    <div class="header-area header3" id="header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6 col-lg-2">
            <div class="logo">
              <a href="{{ url('/') }}">            
                <img src="{{asset('logo.png')}}" alt="" style="max-width: 45% !important;">
              </a>
            </div>
          </div>
          <div class="col-6 col-lg-10">

            <div class="mobile-menu d-lg-none">
              <div class="mobile-menu-wrap">
                <span class="menu-line"></span>
                <span class="menu-line"></span>
                <span class="menu-line"></span>
              </div>

            </div>
            <div class="menu-elements">

              <div class="main-menu">
                <div class="row align-items-center d-lg-none mb-4">
                  <div class="col-6">
                    <div class="logo">
                      <a href="{{ url('/') }}">                <img src="{{asset('logo.png')}}" alt="" style="max-width: 45% !important;">
                      </a>
                    </div>
                  </div>
                </div>
                <div class="menu-close-btn d-lg-none ">
                  <i class="fal fa-times"></i>
                </div>

                <ul class="menu-list">
                  <li><a href="{{route('/')}}">الرئيسية</a></li>
                  <li><a href="{{route('doctorsall')}}">الأطباء</a></li>
                  <li><a href="{{route('clinic')}}">العيادات</a></li>
                  <li><a href="{{route('inbody')}}">أجهزة InBody</a></li>
                  <li><a href="{{route('articals')}}">مقالات </a></li>
                  <li><a href="{{route('diet')}}">الحمية الغذائية </a></li>

                  
                  <li><a href="{{route('contact')}}">اتصل بنا</a></li>
                </ul>

              </div>
              <div class="action-btn">
                <a href="{{route('login/home')}}" style="padding: 4px 20px; !important" class="cbtn btn-one effect5">تسجيل دخول </a>
                <a href="{{route('login')}}" style="padding-right: 10px;font-size: larger;" class=""><li class="fa fa-sign-in"></li> </a>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  

  @yield('content')
  @include('sweetalert::alert')
 
  <!--====== Subscribe End ======-->

  

  <!--====== Proper  js ======-->
  <script src="{{ asset('theme/assets/js/plugins/popper.min.js') }}"></script>
  <!--====== Bootstrap js ======-->
  <script src="{{ asset('theme/assets/js/plugins/bootstrap.min.js') }}"></script>
  <!--====== Nice select js ======-->
  <script src="{{ asset('theme/assets/js/plugins/jquery.nice-select.js') }}"></script>
  <!--====== Carousel js ======-->
  <script src="{{ asset('theme/assets/js/plugins/slick.js') }}"></script>
  <!--====== Aos  js ======-->
  <script src="{{ asset('theme/assets/js/plugins/aos.js') }}"></script>
  <!--====== Modal Video js ======-->
  <script src="{{ asset('theme/assets/js/plugins/jquery-modal-video.min.js') }}"></script>
  <!--====== active js ======-->
  <script src="{{ asset('theme/assets/js/active.js') }}"></script>
  <!--====== main js ======-->
  <script src="{{ asset('theme/assets/js/main.js') }}"></script>
</body>

</html>