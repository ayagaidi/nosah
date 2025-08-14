@extends('app')
@section('title', 'اتصل بنا')

@section('content')




    <div class="inner-welcome  pt85 bg4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="title">
                        <h1>اتصل بنا</h1>
                    </div>
                    <div class="bread-crumb text-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">اتصل بنا</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-area section-padding inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contacts">
                        <h3>اتصل بنا</h3>
                        <div class="single-contact">
                            <div class="contact-icon">
                                <i class="fal fa-phone-volume"></i>
                            </div>
                            <h4>{{ $contactinfo->phonenumber ?? 'لايوجد' }}</h4>
                        </div>
                        <div class="single-contact">
                            <div class="contact-icon">
                                <i class="fal fa-envelope-open-text"></i>
                            </div>
                            <h4>{{ $contactinfo->email ?? 'لايوجد' }}</h4>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="comment-form">
                        <h3>لنتعاون معاً</h3>
                        <form action="{{ route('inbox.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">الاسم*</label>
                                    <p class="input-field input-name">
                                        <input type="text" id="name" name="name" placeholder="الاسم الكامل"
                                            value="{{ old('name') }}">
                                    </p>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email">البريد الإلكتروني *</label>
                                    <p class="input-field input-email">
                                        <input type="email" id="email" name="email"
                                            placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}">
                                    </p>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <p class="textarea-filed">
                                        <label for="message">الرسالة *</label>
                                        <textarea name="message" id="message" cols="30" rows="10" placeholder="نص رسالتك">{{ old('message') }}</textarea>
                                    </p>
                                    @error('message')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <button type="submit" class="submit-btn submit-btn3">إرسال الرسالة</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
