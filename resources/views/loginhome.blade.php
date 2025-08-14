@extends('app')
@section('title','الرئيسية')

@section('content')
 
  <!--====== Feature Start ======-->
  <div class="feature-awesome section-padding2">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 m-auto text-center" data-aos="fade-up" data-aos-offset="100" data-aos-easing="ease-in-sine" data-aos-duration="500" data-aos-delay="500">
          <div class="heading mb60">
            <h2>تسجيل دخول</h2>
            <p></p>
          </div>
        </div>
      </div>

      <div class="row">
        <a class="col-md-6 col-lg-6" href="{{route('doctor.login')}}">
          <div class="feature-box">
              <img src="{{ asset('logindoc.png') }}" alt="">
            <h3 style="text-align: center">الطبيب</h3>
          </div>
        </a>
        <a class="col-md-6 col-lg-6" href="{{route('patient.login')}}">
         <div class="feature-box">
              <img src="{{ asset('pation.png') }}" alt="">
            <h3 style="text-align: center">المريض</h3>
          </div>
        </a>
        
      </div>
    </div>
  </div>
  <!--====== Feature End ======-->

 


  @endsection