@extends('patient.app')

@section('content')
@section('title', 'الجدول الغدائي')

<div class="inner-welcome pt85 bg4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="title">
                    <h1>الجدول الغدائي</h1>
                </div>
                <div class="bread-crumb text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">الجدول الغدائي</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="meal-plan-section" style="padding: 4rem 2rem; background-color: #f9f9f9;">
  <h2 style="text-align:center; font-size:2rem; color:#112132; margin-bottom:2rem;">وجبات الأسبوع</h2>
  <div class="meal-grid row" id="diet-cards-row" style="
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap:1.5rem;
  ">
    {{-- سيتم ملء البطاقات عبر Ajax --}}
  </div>
  <div id="diet-pagination" class="d-flex justify-content-center mt-4"></div>
</section>

<script>
function loadDietPlans(page = 1) {
    $.ajax({
        url: '{{ route('patient.diet_plan.all') }}',
        type: 'GET',
        data: { page: page, per_page: 9 },
        dataType: 'json',
        success: function(response) {
            let data = response.data || [];
            let html = '';
            if (data.length === 0) {
                html = '<div class="col-12 text-center"><h4>لا توجد وجبات غذائية متاحة</h4></div>';
            }
            data.forEach(function(item) {
                // Use patient diet plan show route
                let showUrl = item.id ? `{{ url('patient/diet-plan/showdietplan') }}/${item.id}` : '#';
                html += `
                <div class="meal-card" style="
                  background:#fff;
                  border-radius:8px;
                  box-shadow:0 4px 12px rgba(0,0,0,0.05);
                  overflow:hidden;
                  display:flex;
                  flex-direction:column;
                ">
                  <img src="{{ asset('diettplan.png') }}" alt="${item.food_item || 'وجبة'}" style="width:100%; height:180px; object-fit:cover;">
                  <div style="padding:1rem; flex:1; display:flex; flex-direction:column;">
                    <h3 style="font-size:1.25rem; color:#004f51; margin-bottom:0.5rem;">${item.food_item || '-'}</h3>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success" style="font-size:14px;">${item.meal_type || '-'}</span>
                        <span class="text-muted" style="font-size:13px;">${item.date || '-'}</span>
                    </div>
                    <p style="font-size:0.9rem; color:#555; flex:1; margin-bottom:1rem;">
                        <strong>الفئة:</strong> ${item.food_category || '-'}<br>
                        <strong>الحجم:</strong> ${item.portion_size || '-'}
                    </p>
                    <ul style="list-style:none; padding:0; margin:0 0 1rem; display:flex; flex-wrap:wrap; gap:0.75rem; font-size:0.85rem;">
                      <li>🍽️ <strong>السعرات:</strong> ${item.calories || '-'}</li>
                      <li>⚖️ <strong>البروتين:</strong> ${item.protein || '-'}</li>
                      <li>🔥 <strong>الكربوهيدرات:</strong> ${item.carbs || '-'}</li>
                      <li>🥑 <strong>الدهون:</strong> ${item.fat || '-'}</li>
                      <li>🌱 <strong>الألياف:</strong> ${item.fiber || '-'}</li>
                      <li>💧 <strong>السوائل:</strong> ${item.fluid_intake || '-'}</li>
                    </ul>
                    <p class="mb-1"><strong>المكملات:</strong> ${item.supplements || '-'}</p>
                    <div class="text-end mt-2">
                        <a href="${showUrl}" class="btn btn-outline-success btn-sm" title="عرض التفاصيل">
                            <i class="fa fa-eye"></i> عرض
                        </a>
                    </div>
                  </div>
                </div>
                `;
            });
            $('#diet-cards-row').html(html);

            // Pagination
            let pagination = '';
            if (response.last_page > 1) {
                pagination += `<nav><ul class="pagination">`;
                for (let i = 1; i <= response.last_page; i++) {
                    pagination += `<li class="page-item${i === response.current_page ? ' active' : ''}">
                        <a class="page-link" href="#" onclick="loadDietPlans(${i});return false;">${i}</a>
                    </li>`;
                }
                pagination += `</ul></nav>`;
            }
            $('#diet-pagination').html(pagination);
        },
        error: function() {
            $('#diet-cards-row').html('<div class="col-12 text-center"><h4>حدث خطأ أثناء جلب البيانات</h4></div>');
            $('#diet-pagination').html('');
        }
    });
}

$(function() {
    loadDietPlans();
});
</script>
@endsection
