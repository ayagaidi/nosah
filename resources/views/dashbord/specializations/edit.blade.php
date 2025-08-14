@extends('layouts.app')
@section('title','تعديل تخصص')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content ">
            <h4 class="box-title"><a href="{{ route('specializations') }}">التخصصات</a>/تعديل تخصص</h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box-content">
            <form method="POST" class="" action="">
                @csrf
                <div class="form-group">
                    <label for="inputName" class="control-label">اسم تخصص</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $specialization->name }}" id="name" placeholder="اسم تخصص" >
                    @error('name')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
             
                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل تخصص</button>
                </div>
            </form>
        </div>
        <!-- /.box-content -->
    </div>
    <!-- /.col-xs-12 -->
</div>
@endsection