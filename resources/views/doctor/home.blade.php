@extends('doctor.app')

@section('content')
@section('title', 'الرئيسية')
<style>
    /* تصميم زر 3D */
    .btn-3d {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 5px 5px 15px #bebebe, -5px -5px 15px #ffffff;
        text-decoration: none;
        font-weight: bold;
        color: #333;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* تأثير النقر */
    .btn-3d:active {
        box-shadow: inset 5px 5px 10px #bebebe, inset -5px -5px 10px #ffffff;
        transform: translateY(4px);
    }

    /* أيقونات الأزرار */
    .btn-3d .icon {
        width: 80px;
        transition: transform 0.3s ease;
    }

    /* تأثير عند تمرير الماوس */
    .btn-3d:hover .icon {
        transform: scale(1.1);
    }

    /* تحسين النص */
    .btn-3d span {
        margin-top: 10px;
        font-size: 16px;
    }
</style>
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('doctor.dashboard') }}">الرئيسية</a> / بحث عن مريض
            </h4>
        </div>

    </div>
    <div class="col-md-12 col-md-offset-3">
        <div class="box-content">
            <form method="POST" action="{{ route('doctor.searchPatient') }}">
                @csrf
                <div class="form-group col-md-10">
                    <label>رقم المريض</label>
                    <input type="text" value="{{old('patient_id')}}" name="patient_id" class="form-control" required>
                </div>
                <div class="form-group col-md-2 text-center" style="margin-top: 31px;">
                    <button type="submit" class="btn btn-primary">
                        <li class="fa fa-search"></li>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($patient))
        <div class="col-md-12">
            <div class="box-content">
                <div class="col-md-12">
                    <div class="col-md-4 col-sm-12 mb-4">
                        <a style="color: #acbf78;" href="{{ route('doctor.patients.show', encrypt($patient->id)) }}" class="btn-3d">
                            <img class="icon" src="{{ asset('info.png') }}" alt="info">
                            <span style="color: #acbf78;">بيانات المريض</span>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-4">
                        <a style="color: #acbf78;" href="{{ route('doctor.appointments.index', $patient->id) }}" class="btn-3d">
                            <img class="icon" src="{{ asset('appointments.png') }}" alt="appointments">
                            <span style="color: #acbf78;">المواعيد</span>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-4">
                                                <a style="color: #acbf78;" href="{{ route('doctor.diet_plans.index', $patient->id) }}" class="btn-3d">

                            <img class="icon" src="{{ asset('Dietplan.png') }}" alt="Dietplan">
                            <span style="color: #acbf78;">الخطة الغذائية</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
       
    @endif
</div>
@endsection
