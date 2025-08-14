@extends('patient.app')

@section('content')
<style>
    .plan-card {
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background-color: #ffffff;
        padding: 2rem;
        transition: 0.3s ease;
    }

    .plan-card:hover {
        transform: scale(1.01);
    }

    .plan-detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #eaeaea;
    }

    .plan-detail-item:last-child {
        border-bottom: none;
    }

    .plan-label {
        font-weight: bold;
        color: #555;
    }

    .plan-value {
        color: #333;
    }

    .back-btn {
        background-color: #16a085;
        color: white;
        border-radius: 30px;
        padding: 0.5rem 1.5rem;
        transition: 0.2s ease;
    }

    .back-btn:hover {
        background-color: #138d75;
    }
</style>

<div class="inner-welcome pt85 bg4">
    <div class="container text-center">
        <div class="title">
            <h1>تفاصيل خطة النظام الغذائي</h1>
        </div>
        <div class="bread-crumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">الخطة</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="plan-card">
        <h4 class="mb-4 text-center text-primary">الخطة بتاريخ: {{ \Carbon\Carbon::parse($plan->date)->format('Y-m-d') }}</h4>

        <div class="plan-detail-item">
            <span class="plan-label">نوع الوجبة:</span>
            <span class="plan-value">{{ $plan->meal_type }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">فئة الطعام:</span>
            <span class="plan-value">{{ $plan->food_category }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">عنصر الطعام:</span>
            <span class="plan-value">{{ $plan->food_item }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">حجم الحصة:</span>
            <span class="plan-value">{{ $plan->portion_size }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">السعرات الحرارية:</span>
            <span class="plan-value">{{ $plan->calories }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">الكربوهيدرات:</span>
            <span class="plan-value">{{ $plan->carbs }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">البروتين:</span>
            <span class="plan-value">{{ $plan->protein }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">الدهون:</span>
            <span class="plan-value">{{ $plan->fat }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">الألياف:</span>
            <span class="plan-value">{{ $plan->fiber }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">كمية السوائل:</span>
            <span class="plan-value">{{ $plan->fluid_intake }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">المكملات:</span>
            <span class="plan-value">{{ $plan->supplements }}</span>
        </div>
        <div class="plan-detail-item">
            <span class="plan-label">الطبيب المعالج:</span>
            <span class="plan-value">{{ $doctor->fullname ?? '-' }}</span>
        </div>

       
    </div>
</div>
@endsection
