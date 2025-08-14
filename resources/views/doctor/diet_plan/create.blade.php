@extends('doctor.app')
@section('title', 'إضافة خطة غذائية')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('doctor.diet_plans.index', $patient->id) }}">خطط المريض الغذائية</a> / إضافة خطة جديدة
            </h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content row">
            <form method="POST" action="{{ route('doctor.diet_plans.store', $patient->id) }}">
                @csrf
                <div class="form-group col-md-4">
                    <label>تاريخ الخطة</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>نوع الوجبة</label>
                    <input type="text" name="meal_type" class="form-control" value="{{ old('meal_type') }}" placeholder="مثال: إفطار" required>
                </div>
                <div class="form-group col-md-4">
                    <label>فئة الطعام</label>
                    <input type="text" name="food_category" class="form-control" value="{{ old('food_category') }}" placeholder="مثال: بروتينات" >
                </div>
                <div class="form-group col-md-4">
                    <label>العنصر الغذائي</label>
                    <input type="text" name="food_item" class="form-control" value="{{ old('food_item') }}" placeholder="مثال: دجاج مشوي" required>
                </div>
                <div class="form-group col-md-4">
                    <label>حجم الحصة</label>
                    <input type="text" name="portion_size" class="form-control" value="{{ old('portion_size') }}" placeholder="مثال: 100 غرام">
                </div>
                <div class="form-group col-md-4">
                    <label>السعرات</label>
                    <input type="number" name="calories" class="form-control" value="{{ old('calories') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>الكربوهيدرات (غ)</label>
                    <input type="number" step="0.01" name="carbs" class="form-control" value="{{ old('carbs') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>البروتين (غ)</label>
                    <input type="number" step="0.01" name="protein" class="form-control" value="{{ old('protein') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>الدهون (غ)</label>
                    <input type="number" step="0.01" name="fat" class="form-control" value="{{ old('fat') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>الألياف (غ)</label>
                    <input type="number" step="0.01" name="fiber" class="form-control" value="{{ old('fiber') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>السوائل (مل/لتر)</label>
                    <input type="text" name="fluid_intake" class="form-control" value="{{ old('fluid_intake') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>المكملات</label>
                    <input type="text" name="supplements" class="form-control" value="{{ old('supplements') }}">
                </div>
                <div class="form-group col-md-6">
                    <label>تعليمات خاصة</label>
                    <textarea name="special_instructions" class="form-control">{{ old('special_instructions') }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>موانع أو حساسية</label>
                    <textarea name="dietary_restrictions" class="form-control">{{ old('dietary_restrictions') }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>ملاحظات الالتزام</label>
                    <textarea name="compliance_notes" class="form-control">{{ old('compliance_notes') }}</textarea>
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">حفظ الخطة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
