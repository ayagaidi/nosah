@extends('doctor.app')
@section('title', 'تعديل موعد')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">تعديل موعد للمريض: {{ $patient->full_name }}</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content row">
            <form method="POST" action="{{ route('doctor.appointments.update', [$patient->id, $appointment->id]) }}">
                @csrf
                @method('PUT')
                <div class="form-group col-md-4">
                    <label>العيادة</label>
                    <select name="clinic_id" class="form-control" required>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ $appointment->clinic_id == $clinic->id ? 'selected' : '' }}>{{ $clinic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>تاريخ ووقت الموعد</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>نوع الموعد</label>
                    <select name="appointment_type" class="form-control" required>
                        <option value="كشف" {{ $appointment->appointment_type == 'كشف' ? 'selected' : '' }}>كشف</option>

                        <option value="مراجعة" {{ $appointment->appointment_type == 'مراجعة' ? 'selected' : '' }}>مراجعة</option>
                        <option value="استشارة" {{ $appointment->appointment_type == 'استشارة' ? 'selected' : '' }}>استشارة</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>ملاحظات</label>
                    <textarea name="notes" class="form-control">{{ $appointment->notes }}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label>سبب إعادة الجدولة (اختياري)</label>
                    <input type="text" name="reschedule_reason" class="form-control" value="{{ $appointment->reschedule_reason }}">
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">تحديث الموعد</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
