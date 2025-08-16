@extends('patient.app')

@section('content')
@section('title', 'الرئيسية')
<style>
    h2.inline {
        display: inline;
    }

    .our-offer-items .item {
        background-color: #f9f9f9;
        /* Light gray background */
        border: 1px solid #09c8ad;
        /* Light border */
        border-radius: 8px;
        /* Rounded corners */
        padding: 20px;
        /* Spacing inside the box */
        text-align: center;
        /* Center the text */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth transition */
    }

    .our-offer-items .item:hover {
        transform: translateY(-10px);
        /* Move up on hover */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        /* Enhance shadow on hover */
    }

    .our-offer-items .item i {
        font-size: 36px;
        /* Icon size */
        color: #09c8ad;
        /* Icon color, adjust as needed */
        margin-bottom: 15px;
        /* Space below the icon */
    }

    .our-offer-items .item h4 {
        font-size: 20px;
        /* Title size */
        margin-bottom: 10px;
        /* Space below the title */
        color: #333;
        /* Title color */
    }

    .our-offer-items .item p {
        font-size: 14px;
        /* Text size */
        color: #666;
        /* Text color */
        line-height: 1.6;
        /* Line spacing */
    }

    .our-offer-items .item a {
        color: #09c8ad;
        /* Link color */
        font-weight: bold;
        /* Bold link text */
        text-decoration: none;
        /* Remove underline */
    }

    .our-offer-items .item a:hover {
        text-decoration: underline;
        /* Underline on hover */
    }
</style>
<div class="inner-welcome pt85 bg4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="title">
                    <h1>الرئيسية</h1>
                </div>
                <div class="bread-crumb text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">
                                    <h2 style="display: inline;">مرحباً بك {{ Auth::user()->full_name }}</h2>
                                </a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row small-spacing mt-5">

    <div class="row our-offer-items less-carousel">

        <div class="col-md-6 col-sm-6 equal-height">
            <div class="item">
                <i class="fas fa-user-edit"></i>
                <h4>بياناتي الشخصية</h4>
                <p>
                    عرض بياناتك الشخصية، مثل اسم المستخدم والبريد الالكتروني .
                    <a href="{{ route('patient.profile') }}">بياناتي الشخصية</a>
                </p>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 equal-height">
            <div class="item">
                <i class="fas fa-key"></i>
                <h4>تغيير كلمة المرور</h4>
                <p>
                    حماية حسابك بتغيير كلمة المرور بشكل دوري.

                    <a href="{{ route('patient.changepassword.form', Auth::user()->id) }}">تغيير كلمة المرور</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
