@extends('app')
@section('title', 'الآطباء')



@section('content')
    <div class="inner-welcome pt85 bg4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="title">
                        <h1>الأطباء</h1>
                    </div>
                    <div class="bread-crumb text-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">الأطباء</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-area blog2 section-padding inner-bg">
        <div class="container">
            <div class="row g-4">
    @forelse($doctors as $doctor)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="mb-3">
                        @if ($doctor->image)
                            <img src="{{ asset('images/doctors/' . $doctor->image) }}" alt="{{ $doctor->fullname }}"
                                 class="rounded-circle img-thumbnail shadow"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img src="{{ asset('docotr.png') }}" alt="{{ $doctor->fullname }}"
                                 class="rounded-circle img-thumbnail shadow"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @endif
                    </div>

                    <h6 class="fw-bold mb-1">{{ $doctor->fullname }}</h6>
                    <p class="text-muted small mb-2">
                        {{ $doctor->specializations->name ?? 'بدون تخصص' }}
                    </p>

                    @if (!empty($doctor->cv))
                        <a href="{{ asset('doctors/cv/' . $doctor->cv) }}" target="_blank"
                           class="btn btn-sm btn-outline-success mt-auto">
                            <i class="fa fa-file-pdf me-1"></i> عرض السيرة الذاتية
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <div class="alert alert-info">لا يوجد أطباء حالياً.</div>
        </div>
    @endforelse

    <div class="col-12 text-center mt-4">
        {{ $doctors->links() }}
    </div>
</div>

        </div>
    </div>
@endsection
