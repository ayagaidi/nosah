@extends('layouts.app')
@section('content')
<div class="row small-spacing">
  <div class="col-md-12">
    <div class="box-content">
      {{-- only show add button if no contactinfo exists --}}
      @if(!$ContactInfo)
        <a href="{{ route('contactinfos/create') }}"
           class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
          إضافة جديد
        </a>
      @endif
    </div>
  </div>

  <div class="col-md-12">
    <div class="box-content">
      <h4 class="box-title">معلومات الاتصال</h4>
      <div class="table-responsive" data-pattern="priority-columns">
        <table id="datatable-contactinfos"
               class="table table-bordered table-hover js-basic-example dataTable table-custom">
          <thead>
            <tr>
              <th>رقم الهاتف</th>
              <th>البريد الإلكتروني</th>
              <th></th> {{-- actions column --}}
            </tr>
          </thead>
          <tbody>
            <script>
              $(document).ready(function(){
                $('#datatable-contactinfos').DataTable({
                  language:{ url: '../Arabic.json' },
                  processing: true,
                  serverSide: true,
                  ajax: '{!! route("contactinfos/infos") !!}',
                  columns: [
                    { data:'phonenumber', name:'phonenumber' },
                    { data:'email',        name:'email'      },
                    { data:'edit',         name:'edit', orderable:false, searchable:false }
                  ],
                  dom: 'Blfrtip',
                  buttons: [
                    // { extend:'copyHtml5', exportOptions:{columns:':visible'}, text:'نسخ' },
                    { extend:'excelHtml5',exportOptions:{columns:':visible'}, text:'excel تصدير كـ ' },
                    { extend:'colvis',    text:'الأعمدة' }
                  ]
                });
              });
            </script>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection