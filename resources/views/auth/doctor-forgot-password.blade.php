@extends('app')
@section('title','نسيت كلمة المرور')

@section('content')
  <!--====== Forgot Password Start ======-->
  <div class="hero-area flex-lg-middle pt85">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-lg-7">
          <div class="title xss-text-center" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine" data-aos-duration="1000">
            <h1>نسيت كلمة المرور</h1>
            <p>يرجى إدخال البريد الإلكتروني الخاص بك لاستعادة كلمة المرور.</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('doctor.forgot-password.post') }}" class="mt-4 p-4 rounded shadow bg-white" >
                @csrf
                <div class="form-group mb-3">
                    <label for="email" class="mb-1">البريد الإلكتروني</label>
                    <input type="email" style="text-align: right;" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required placeholder="البريد الإلكتروني" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback d-block" style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">إرسال كلمة المرور الجديدة عبر واتساب</button>
            </form>
          </div>
        </div>
        <div class="col-lg-5 text-lg-right">
          <div class="hero-soft2" data-aos="fade-left" data-aos-offset="300" data-aos-easing="ease-in-sine" data-aos-duration="1000" data-aos-delay="500">
            <img src="{{ asset('logindoc.png') }}" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--====== Forgot Password End ======-->
@endsection
