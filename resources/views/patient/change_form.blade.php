@extends('patient.app')

@section('title','تغيير كلمة المرور')

@section('content')
<div class="inner-welcome pt85 bg4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="title">
                    <h1>تغيير كلمة المرور</h1>
                </div>
                <div class="bread-crumb text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">تغيير كلمة المرور</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ هنا نضيف div ليكون في منتصف الصفحة -->
<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-6">
        <div class="box-content shadow p-4 rounded" style="background: #fff;">
            <form method="POST" action="">
                @csrf
                <div class="form-group">
                    <label for="current-password" class="control-label">{{ trans('users.current-password') }}</label>
                    <input type="password" name="current-password" class="form-control @error('current-password') is-invalid @enderror" value="{{ old('current-password') }}" id="current-password" placeholder="{{ trans('users.current-password') }}">
                    @error('current-password')
                        <span class="invalid-feedback" style="color: red" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new-password" class="control-label">{{ trans('users.new-password') }}</label>
                    <input type="password" name="new-password" class="form-control @error('new-password') is-invalid @enderror" value="{{ old('new-password') }}" id="new-password" placeholder="{{ trans('users.new-password') }}">
                    @error('new-password')
                        <span class="invalid-feedback" style="color: red" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new-password-confirm" class="control-label">{{ trans('users.new-password-confirm') }}</label>
                    <input type="password" name="new-password-confirm" class="form-control @error('new-password-confirm') is-invalid @enderror" value="{{ old('new-password-confirm') }}" id="new-password-confirm" placeholder="{{ trans('users.new-password-confirm') }}">
                    @error('new-password-confirm')
                        <span class="invalid-feedback" style="color: red" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group text-center" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary">{{ trans('users.passbtn') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
