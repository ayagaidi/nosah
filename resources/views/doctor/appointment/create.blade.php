@extends('doctor.app')
@section('title', 'إضافة موعد')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">إضافة موعد للمريض: {{ $patient->full_name }}</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content row">
            <form method="POST" action="{{ route('doctor.appointments.store', $patient->id) }}">
                @csrf
                <div class="form-group col-md-4">
                    <label>العيادة</label>
                    <select name="clinic_id" class="form-control" required>
                        <option value="">اختر العيادة</option>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>تاريخ ووقت الموعد</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label>نوع الموعد</label>
                    <select name="appointment_type" class="form-control" required>
                                                <option value="كشف">كشف</option>

                        <option value="مراجعة">مراجعة</option>
                        <option value="استشارة">استشارة</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>ملاحظات</label>
                    <textarea name="notes" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">حفظ الموعد</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
