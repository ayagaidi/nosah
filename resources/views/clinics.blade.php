@extends('app')
@section('title', 'العيادات')

@section('content')




    <div class="inner-welcome  pt85 bg4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="title">
                        <h1>العيادات</h1>
                    </div>
                    <div class="bread-crumb text-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('/')}}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">العيادات</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="products-wrap  mr-lg-40">
                        <div class="row align-items-center">
                            @if($clinics->count())
                                @foreach ($clinics as $item)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="single-products shadow rounded h-100 d-flex flex-column">
                                        <div class="products-img position-relative">
                                            <img src="{{ asset('clinics.png') }}" alt="" class="img-fluid rounded-top" style="height:180px;object-fit:cover;">
                                           
                                        </div>
                                        <div class="products-content flex-grow-1 d-flex flex-column justify-content-between p-3">
                                            <div class="text-center mb-2">
                                                <h3 class="mb-1" style="font-size:1.2rem;">{{ $item->name }}</h3>
                                                <h4 class="mb-1 text-muted" style="font-size:1rem;">{{ $item->phone_number }}</h4>
                                            </div>
                                            <div class="text-center mb-2">
                                                <h4 style="font-size:small;" class="product-price mb-1" style="font-size:1rem;">
                                                    {{ $item->address }} - {{ $item->cities->name }}
                                                </h4>
                                            </div>
                                            <div class="text-center">
                                                @if($item->url_location)
                                                    <a href="{{ $item->url_location }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="fa fa-location-arrow"></i> الموقع على الخريطة
                                                    </a>
                                                @else
                                                    <span class="text-muted small">لا يوجد موقع</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <p>لا يوجد عيادات </p>
                                </div>
                            @endif
                            <div class="col-12 text-center mt-4">
                                {{ $clinics->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="blog-sidebar mt-sm-60">
                        <div class="widget widget-search mb60">
                            <h3>بحث</h3>
                            <div class="search-from">
                                <form action="{{ route('clinic') }}" method="GET">
                                    <input type="search" name="search" placeholder="ابحث عن عيادة..." value="{{ request('search') }}">
                                    <button type="submit" class="seach-btn"><i class="far fa-search"></i></button>
                            </form>
                            </div>
                        </div>
                        <!-- يمكنك إضافة المزيد من الودجات هنا -->
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
