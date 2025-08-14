@extends('doctor.app')
@section('title','عرض مريض')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"><a href="{{ route('doctor.patients') }}">المرضى</a>/عرض مريض</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>اسم المريض</th>
                        <td>{{ $patient->full_name }}</td>
                    </tr>
                    <tr>
                        <th>تاريخ الميلاد</th>
                        <td>{{ $patient->dob }}</td>
                    </tr>
                    <tr>
                        <th>الجنس</th>
                        <td>{{ $patient->gender == 'M' ? 'ذكر' : 'أنثى' }}</td>
                    </tr>
                    <tr>
                        <th>الوزن (كجم)</th>
                        <td>{{ $patient->weight }}</td>
                    </tr>
                    <tr>
                        <th>الطول (سم)</th>
                        <td>{{ $patient->height }}</td>
                    </tr>
                    <tr>
                        <th>رقم التواصل</th>
                        <td>{{ $patient->contact_number }}</td>
                    </tr>
                    <tr>
                        <th>العنوان</th>
                        <td>{{ $patient->address }}</td>
                    </tr>
                    <tr>
                        <th>التاريخ الطبي</th>
                        <td>{{ $patient->medical_history }}</td>
                    </tr>
                    <tr>
                        <th>الحساسية</th>
                        <td>{{ $patient->allergies }}</td>
                    </tr>
                    <tr>
                        <th>الأدوية</th>
                        <td>{{ $patient->medications }}</td>
                    </tr>
                    <tr>
                        <th>البريد الإلكتروني</th>
                        <td>{{ $patient->email }}</td>
                    </tr>
                    <tr>
                        <th>الملفات</th>
                        <td>
                            <ul>
                                @foreach($patient->files as $file)
                                    <li><a href="{{ asset($file->file_path) }}" target="_blank">{{ $file->title }}</a></li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
