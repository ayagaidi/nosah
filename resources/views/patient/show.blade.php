@extends('patient.app')
@section('title','بياناتي')

@push('styles')
<style>
    body {
        background-color: #f9fbfc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .box-content.card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
        transition: transform 0.3s ease;
    }

    .box-content.card:hover {
        transform: translateY(-4px);
    }

    .card-content {
        padding: 2rem;
    }

    .box-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 12px;
        margin-bottom: 1.5rem;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 12px;
        width: 100%;
        font-size: 15.5px;
    }

    .table thead th {
        background-color: #f1f5f9;
        border: none;
        padding: 14px 18px;
        font-weight: 600;
        color: #212529;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .table tbody td {
        background-color: #fff;
        border: none;
        padding: 14px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0 0 0.75rem 0.75rem;
    }

    .table tbody tr {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 16px;
        display: table-row;
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fb;
    }

    .badge-success {
        background-color: #28a745;
        padding: 6px 16px;
        font-weight: 600;
        border-radius: 50px;
    }

    .badge-danger {
        background-color: #dc3545;
        padding: 6px 16px;
        font-weight: 600;
        border-radius: 50px;
    }

    .btn-outline-primary {
        border-radius: 0.5rem;
        font-weight: 600;
        padding: 8px 20px;
        transition: 0.3s;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .alert-secondary {
        background-color: #f8f9fa;
        color: #6c757d;
        font-size: 16px;
        font-weight: 500;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .card-content {
            padding: 1.25rem;
        }

        .box-title {
            font-size: 1.25rem;
        }

        .table th,
        .table td {
            padding: 10px;
            font-size: 14px;
        }

        .btn-outline-primary {
            font-size: 14px;
            padding: 6px 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="inner-welcome pt85 bg4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="title">
                    <h1>بياناتي</h1>
                </div>
                <div class="bread-crumb text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">بياناتي</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
            <!-- البيانات الشخصية -->
            <div class="col-lg-6 mb-4">
                <div class="info-card">
                    <div class="section-title text-primary">
                        <i class="fa fa-user"></i> المعلومات الشخصية
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6"><div class="info-item"><span class="info-label">رقم المريض:</span><span class="info-value">{{ $patient->patient_number }}</span></div></div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">الاسم الكامل:</span><span class="info-value">{{ $patient->full_name }}</span></div></div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">البريد الإلكتروني:</span><span class="info-value">{{ $patient->email }}</span></div></div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">تاريخ الميلاد:</span><span class="info-value">{{ \Carbon\Carbon::parse($patient->dob)->format('Y-m-d') }}</span></div></div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">الجنس:</span><span class="info-value">{{ $patient->gender == 'M' ? 'ذكر' : 'أنثى' }}</span></div></div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">رقم التواصل:</span><span class="info-value">{{ $patient->contact_number }}</span></div></div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">الحالة:</span>
                            <span class="info-value">
                                <span class="badge {{ $patient->active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $patient->active ? 'مفعل' : 'غير مفعل' }}
                                </span>
                            </span></div>
                        </div>
                        <div class="col-md-6"><div class="info-item"><span class="info-label">العنوان:</span><span class="info-value">{{ $patient->address }}</span></div></div>
                    </div>
                </div>
            </div>

            <!-- المعلومات الطبية -->
            <div class="col-lg-6 mb-4">
                <div class="info-card">
                    <div class="section-title text-info">
                        <i class="fa fa-heartbeat"></i> معلومات طبية
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12"><div class="info-item"><span class="info-label">التاريخ الطبي:</span><span class="info-value">{{ $patient->medical_history ?: 'لا يوجد' }}</span></div></div>
                        <div class="col-md-12"><div class="info-item"><span class="info-label">الحساسية:</span><span class="info-value">{{ $patient->allergies ?: 'لا يوجد' }}</span></div></div>
                        <div class="col-md-12"><div class="info-item"><span class="info-label">الأدوية:</span><span class="info-value">{{ $patient->medications ?: 'لا يوجد' }}</span></div></div>
                    </div>
                </div>
            </div>

            <!-- ملفات المريض -->
            <div class="col-12">
                <div class="info-card">
                    <div class="section-title text-warning">
                        <i class="fa fa-folder-open"></i> ملفات المريض
                    </div>
                    @if($patient->files && $patient->files->count())
                        <div class="row g-3">
                            @foreach($patient->files as $file)
                                <div class="col-md-6">
                                    <div class="info-item d-flex justify-content-between align-items-center">
                                        <span class="info-label">{{ $file->title }}</span>
                                        <a href="{{ asset($file->file_path) }}" target="_blank" class="btn btn-outline-primary file-button">
                                            <i class="fa fa-file-pdf-o"></i> عرض
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-secondary">لا توجد ملفات مرفقة.</div>
                    @endif
                </div>
            </div>
        </div>
</div>
@endsection
