@extends('dashbord.layouts.master')
@section('content')
<div class="row small-spacing">
  <div class="col-md-12">
    <div class="box-content">
      <a href="{{ route('clinics/create') }}"
         class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
        إضافة عيادة
      </a>
    </div>
  </div>

  <div class="col-md-12">
    <div class="box-content">
      <h4 class="box-title">عرض العيادات</h4>
      <div class="table-responsive" data-pattern="priority-columns">
        <table id="datatable-clinics"
               class="table table-bordered table-hover js-basic-example dataTable table-custom"
               style="cursor: pointer;">
          <thead>
            <tr>
              <th>اسم العيادة</th>
              <th>العنوان</th>
              <th>رقم الهاتف</th>
              <th>الموقع</th>
              <th>تاريخ الإنشاء</th>
              <th>تعديل</th>
              <th>الحالة</th>
              <th>الأطباء والتخصصات</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
  $('#datatable-clinics').DataTable({
    language: { url: '../Arabic.json' },
    processing: true,
    serverSide: true,
    ajax: '{!! route("clinics/clinics") !!}',
    columns: [
      { data: 'name',        name: 'name',        defaultContent: 'لا يوجد' },
      { data: 'address',     name: 'address',     defaultContent: 'لا يوجد' },
      { data: 'phone_number',name: 'phone_number',defaultContent: 'لا يوجد' },
      { data: 'url_location',name: 'url_location',
        render: function(d){
          return d
            ? `<a href="${d}" target="_blank"><i class="fa fa-map-marker text-primary"></i></a>`
            : 'لا يوجد';
        }
      },
      { data: 'created_at',  name: 'created_at',  defaultContent: 'لا يوجد' },
      { data: 'edit',        name: 'edit',        orderable: false, searchable: false },
      { data: 'changeStatus',name: 'changeStatus',orderable: false, searchable: false },
      { data: 'viewDoctors', name: 'viewDoctors', orderable: false, searchable: false }
    ],
    dom: 'Blfrtip',
    buttons: [
      // { extend: 'copyHtml5',   text: 'نسخ',             exportOptions: { columns: ':visible' } },
      { extend: 'excelHtml5',  text: 'Excel تصدير',     exportOptions: { columns: ':visible' } },
      { extend: 'colvis',      text: 'الأعمدة' }
    ]
  });
});
</script>
@endpush
