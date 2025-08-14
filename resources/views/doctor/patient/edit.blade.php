@extends('doctor.app')
@section('title', 'تعديل مريض')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title"><a href="{{ route('doctor.patients') }}">المرضى</a>/تعديل مريض</h4>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box-content row">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-md-6">
                        <label for="full_name" class="control-label">اسم المريض</label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name', $patient->full_name) }}" id="full_name" placeholder="اسم المريض">
                        @error('full_name')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dob" class="control-label">تاريخ الميلاد</label>
                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                            value="{{ old('dob', $patient->dob) }}" id="dob" placeholder="تاريخ الميلاد">
                        @error('dob')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender" class="control-label">الجنس</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">اختر الجنس</option>
                            <option value="M" {{ old('gender', $patient->gender) == 'M' ? 'selected' : '' }}>ذكر
                            </option>
                            <option value="F" {{ old('gender', $patient->gender) == 'F' ? 'selected' : '' }}>أنثى
                            </option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact_number" class="control-label">رقم التواصل</label>
                        <input type="text" name="contact_number" maxlength="10" pattern="^(094|095|093|092|091)\d{7}$"
                            title="يرجى إدخال رقم تواصل مكون من 10 أرقام ويبدأ بأحد القيم التالية: 094, 095, 093, 092, 091"
                            class="form-control @error('contact_number') is-invalid @enderror"
                            value="{{ old('contact_number', $patient->contact_number) }}" id="contact_number"
                            placeholder="رقم التواصل">
                        @error('contact_number')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="weight" class="control-label">الوزن (كجم)</label>
                        <input type="number" step="0.01" name="weight"
                            class="form-control @error('weight') is-invalid @enderror"
                            value="{{ old('weight', $patient->weight) }}" id="weight" placeholder="الوزن">
                        @error('weight')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="height" class="control-label">الطول (سم)</label>
                        <input type="number" step="0.01" name="height"
                            class="form-control @error('height') is-invalid @enderror"
                            value="{{ old('height', $patient->height) }}" id="height" placeholder="الطول">
                        @error('height')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address" class="control-label">العنوان</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address"
                            placeholder="العنوان">{{ old('address', $patient->address) }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="medical_history" class="control-label">التاريخ الطبي</label>
                        <textarea name="medical_history" class="form-control @error('medical_history') is-invalid @enderror"
                            id="medical_history" placeholder="التاريخ الطبي">{{ old('medical_history', $patient->medical_history) }}</textarea>
                        @error('medical_history')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="allergies" class="control-label">الحساسية</label>
                        <textarea name="allergies" class="form-control @error('allergies') is-invalid @enderror" id="allergies"
                            placeholder="الحساسية">{{ old('allergies', $patient->allergies) }}</textarea>
                        @error('allergies')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="medications" class="control-label">الأدوية</label>
                        <textarea name="medications" class="form-control @error('medications') is-invalid @enderror" id="medications"
                            placeholder="الأدوية">{{ old('medications', $patient->medications) }}</textarea>
                        @error('medications')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="control-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $patient->email) }}" id="email" placeholder="البريد الإلكتروني"
                            required>
                        @error('email')
                            <span class="invalid-feedback" style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <div id="patient-files-section">
                            <label class="control-label">ملفات المريض السابقة</label>
                            <div id="patient-files-list">
                              @foreach ($patient->files as $file)
    <div class="patient-file-row d-flex align-items-center mb-2" style="gap: 10px; flex-wrap: wrap;">
        <!-- عنوان الملف -->
        <input type="text"
            name="existing_patient_files[{{ $file->id }}][title]"
            class="form-control"
            value="{{ $file->title }}"
            placeholder="عنوان الملف"
            style="flex: 1 1 40%; min-width: 200px;"
            required>

        <!-- زر عرض الملف -->
        <a href="{{ asset($file->file_path) }}"
            target="_blank"
            class="btn btn-info btn-sm"
            style="flex: 1 1 25%; min-width: 140px;">
            عرض الملف
        </a>

        <!-- زر حذف -->
        <button type="button"
            class="btn btn-danger btn-sm"
            onclick="this.parentNode.remove()"
            style="flex: 0 0 auto;">
            <i class="fa fa-trash"></i>
        </button>
    </div>
@endforeach

                            </div>

                            <button type="button" class="btn btn-success btn-sm mt-2" onclick="addPatientFileField()">
                                <i class="fa fa-plus"></i> إضافة ملف جديد
                            </button>
                        </div>
                    </div>
                    <div class="form-group col-md-12">

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل بيانات
                                المريض</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addPatientFileField() {
            var idx = document.querySelectorAll('.patient-file-row').length;
            var html = `


    <div class="form-group  patient-file-row d-flex align-items-center mb-2" style="gap:8px;">
            <input type="text" name="patient_files[` + idx + `][title]" class="form-control col-md-6" placeholder="عنوان الملف" style="max-width: 30%;" required>
            <input type="file" name="patient_files[` + idx + `][file]" class="form-control col-md-6" accept="application/pdf,image/jpeg,image/png" style="max-width: 30%;" required>
            <select name="patient_files[` + idx + `][type]" class="form-control col-md-3" required style="max-width: 30%;">
                <option value="">اختر النوع</option>
                <option value="document">مستند</option>
                <option value="image">صورة</option>
            </select>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentNode.remove()"><li class="fa fa-trash"></li></button>
        </div>
    `;
            document.getElementById('patient-files-list').insertAdjacentHTML('beforeend', html);
        }
    </script>
@endsection
