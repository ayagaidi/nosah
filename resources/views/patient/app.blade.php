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
<script src="{{ asset('dash/assets/jquery-datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>

  </head>
<style>
  .table-striped > tbody > tr:nth-of-type(2n+1) > * {
   --bs-table-accent-bg: rgba(146, 176, 64, 0.2);
  }
</style>
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

    <!--====== Cursor Start ======-->
    <div class="cursor cursor3">
        <div class="cursor-dot"></div>
    </div>
    <!--====== Cursor End ======-->


    <!--====== Header Start ======-->
    <header class="absolute-header">
        <div class="header-area header3" id="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-lg-2">
                        <div class="logo">
                            <a href="{{ url('patient/dashboard') }}">
                                <img src="{{ asset('logo.png') }}" alt="" style="max-width: 45% !important;">
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
                                            <a href="{{ url('patient.dashboard') }}"> <img
                                                    src="{{ asset('logo.png') }}" alt=""
                                                    style="max-width: 45% !important;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-close-btn d-lg-none ">
                                    <i class="fal fa-times"></i>
                                </div>

                                <ul class="menu-list">
                                    <li><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                                    <li><a href="{{ route('patient.diet_plan') }}">جدول الغدائي</a></li>
                                    <li><a href="{{ route('patient.appointments') }}">المواعيد</a></li>
                  
        
                                                <li><a href="{{ route('patient.chat.withDoctor', ['doctorId' => Auth::user()->doctors_id]) }}">الإستفسارات</a></li>

 



                                </ul>

                            </div>
                            <div class="action-btn">
                                <a href="{{ route('patient.logout') }}" class="cbtn btn-one effect5">تسجيل خروج </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('content')
    @include('sweetalert::alert')

    <style>
        .doctor-list {
            max-width: 300px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 1rem;
            margin: 1rem;
            border-radius: 8px;
        }
        .doctor-list h3 {
            color: #112132;
            margin-bottom: 1rem;
            text-align: center;
        }
        .doctor-item {
            padding: 0.5rem;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
            color: #112132;
        }
        .doctor-item:last-child {
            border-bottom: none;
        }
        .doctor-item:hover {
            background-color: #0F3440;
            color: white;
        }
    </style>

 

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
