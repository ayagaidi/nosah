<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- logo.ico --}}
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('logo.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nosah-@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('dash/assets/styles/style.min.css') }}">

    <!-- Material Design Icon -->
    <link rel="stylesheet" href="{{ asset('dash/assets/fonts/material-design/css/materialdesignicons.css') }}">

    <!-- mCustomScrollbar -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}">

    <!-- Waves Effect -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/waves/waves.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/iCheck/skins/square/blue.css') }}">

    <!-- RTL -->
    <link rel="stylesheet" href="{{ asset('dash/assets/styles/style-rtl.min.css') }}">
    <!-- cairo -->

    <link rel="stylesheet" href="{{ asset('dash/assets/fonts/cairo.css') }}">



    <script src="{{ asset('dash/assets/scripts/jquery.min.js') }}"></script>
    <script src="{{ asset('dash/assets/scripts/modernizr.min.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/bootstrap/js/bootstrap.min.js') }}"></script>


    <script src="{{ asset('dash/assets/jquery-datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>

    <script src="{{ asset('dash/assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- <script src="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.min.js') }}"></script> -->
    <script src="{{ asset('dash/assets/plugin/waves/waves.min.js') }}"></script>
    <!-- Full Screen Plugin -->
    <script src="{{ asset('dash/assets/plugin/fullscreen/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('sweetalert2@9') }}"></script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.min.js') }}"></script>


    <style>
        .dataTables_wrapper .dt-buttons {
            float: none;
            text-align: left;
        }

        .dataTables_wrapper .dataTables_filter {
            text-align: right;
            float: right;
        }
    </style>

</head>

<body style="font-family:Cairo;">

    <div class="main-menu">
        <header class="header">
            <a href="{{ route('doctor.dashboard') }}" class="logo" style="background-color: white;">
                <img src="{{ asset('logo.png') }}" alt="" style="max-width: 20% !important;">

            </a>
            <button type="button" class="button-close fa fa-times js__menu_close"></button>
        </header>
        <!-- /.header -->
        <div class="content">

            <div class="navigation">
                <ul class="menu js__accordion">
                    <li class="{{ Request::is('doctor/dashboard*') ? 'active' : '' }} ">
                        <a class="waves-effect" href="{{ route('doctor.dashboard') }}"><i
                                class="menu-icon mdi mdi-view-dashboard"></i><span>الرئيسية</span></a>
                    </li>

                    <li class="{{ Request::is('doctor/patients') ? 'active' : '' }} ">

                        <a class="waves-effect" href="{{ route('doctor.patients') }}"><i
                                class="menu-icon fa fa-users"></i><span>المرضى</span></a>
                    </li>
                    </li>

                    <li class="{{ Request::is('doctor/diet-plans/*') ? 'active' : '' }} ">

                        <a class="waves-effect" href="{{ route('doctor.diet_plans.search') }}"><i
                                class="menu-icon fa fa-cutlery"></i><span>الخطة الغذائية</span></a>
                    </li>
                    <li class="{{ Request::is('doctor/appointments/*') ? 'active' : '' }} ">

                        <a class="waves-effect" href="{{ route('doctor.appointments.search') }}"><i
                                class="menu-icon fa fa-calendar"></i><span>المواعيد</span></a>
                    </li>
  <li class="{{ Request::is('doctor/patients/lists') ? 'active' : '' }} ">

                        <a class="waves-effect" href="{{ route('doctor.patients.lists') }}"><i
                                class="menu-icon fa fa-comment-o"></i><span>الإستفسارات</span></a>
                    </li>

                    

                </ul>
                <!-- /.menu js__accordion -->
            </div>
            <!-- /.navigation -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.main-menu -->

    <div class="fixed-navbar">
        <div class="pull-left">
            <button type="button"
                class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
            <h1 class="page-title">@yield('title')</h1>
            <!-- /.page-title -->
        </div>
        <!-- /.pull-left -->
        <div class="pull-right">

            <!-- /.ico-item -->
            <div class="ico-item fa fa-arrows-alt js__full_screen"></div>
            <!-- /.ico-item fa fa-fa-arrows-alt -->

            <!-- /.ico-item -->

            <a href="#" class="ico-item ">
                <h5 class="name">{{ Auth::user()->username }}</h5>
            </a>
            <div class="ico-item">
                <img src="{{ asset('logindoc.png') }}" alt="" class="ico-img">
                <ul class="sub-ico-item">
                    <li><a href="{{ route('doctor.profile', encrypt(Auth::user()->id)) }}"><i class="fa fa-user"></i>
                            {{ trans('app.Profile') }}</a></li>

                    <li><a href="{{ route('doctor.changepassword', encrypt(Auth::user()->id)) }}"><i
                                class="fa fa-lock"></i>{{ trans('app.changepassword') }} </a></li>
                    <li><a href="{{ route('doctor.logout') }}"
                            onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i
                                class="fa fa-sign-out"></i>
                            {{ trans('app.logout') }}</a>
                        <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>>
                    </li>
                </ul>
                <!-- /.sub-ico-item -->
            </div>
            <!-- /.ico-item -->
        </div>
        <!-- /.pull-right -->
    </div>
    <!-- /.fixed-navbar -->

    <!-- /.content -->


    <div id="wrapper">
        <div class="main-content">
            @yield('content')
            @include('sweetalert::alert')

            <!-- /.row -->
            <footer class="footer">
                <ul class="list-inline">
                    <li><?php echo date('Y'); ?> &copy;{{ trans('login.copyright') }} </li>

                </ul>
            </footer>
        </div>
        <!-- /.main-content -->
    </div>


    <script src="{{ asset('dash/assets/scripts/main.min.js') }}"></script>

</body>

</html>
