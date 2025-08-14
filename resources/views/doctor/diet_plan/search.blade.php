@extends('doctor.app')
@section('title', 'بحث عن مريض')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">
                    <a href="{{ route('doctor.diet_plans.search.form') }}">خطط المريض الغذائية</a> / بحث عن مريض
                </h4>
            </div>

        </div>
        <div class="col-md-12 col-md-offset-3">
            <div class="box-content">
                <form method="POST" action="{{ route('doctor.diet_plans.search') }}">
                    @csrf
                    <div class="form-group col-md-8">
                        <label>رقم المريض</label>
                        <input type="text" name="patient_id" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4 text-center" style="margin-top: 31px;">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
