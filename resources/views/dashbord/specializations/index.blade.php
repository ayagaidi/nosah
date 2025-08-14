@extends('layouts.app')
@section('title','التخصصات')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
                
                <a type="button" href="{{ route('specializations/create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3 ">إضافة تخصص</a>

    </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content ">
                <h4 class="box-title">عرض التخصصات</h4>
                <div class="table-responsive" data-pattern="priority-columns">
                <table id="datatable1" class="table table-bordered table-hover js-basic-example dataTable table-custom " style="cursor: pointer;">
                    <thead>
                        <tr>
                            <th>اسم التخصص</th>
                            <th>الحالة</th>

                            <th>تاريخ الإنشاء</th>



 <th></th>
 <th></th>


             
                             

                        </tr>
                    </thead>
                    <tbody>
                        <script>
          
                          $(document).ready( function () {
                         
                             $('#datatable1').dataTable({
                               "language": {
                                "url": "../Arabic.json" //arbaic lang
                         
                                   },
                                   "lengthMenu":[5,10],
                                   "bLengthChange" : true, //thought this line could hide the LengthMenu
                           serverSide: false,
                           paging: true,
                             searching: true,
                             ordering: true,
                             contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                             ajax: '{!! route('specializations/specializations')!!}',
                          
                          columns: [
                                   { data: 'name'},

                                   {
                        data: 'active', 
              render: function(data) { 
                if(data==1) {
                  return 'التخصص مفعل <i class="fa fa-circle" style="color:#2be71b;;" aria-hidden="true"></i>' 
                }
                else {
                  return 'التخصص معطل <i class="fa fa-circle" style="color:#e71b1b;;" aria-hidden="true"></i>'
                }
                
}},
                                   {data: 'created_at'},

                                   {data: 'edit'}  ,
 
                                   {data: 'changeStatus'}  ,

                                ],

                                 dom: 'Blfrtip',

buttons: [
{
extend: 'copyHtml5',
exportOptions: {
columns: [ ':visible' ]
},
text:'نسخ'
},
{
extend: 'excelHtml5',
exportOptions: {
columns: ':visible'
},
text:'excel تصدير كـ '

},
{
extend:  'colvis',
text:'الأعمدة'

},
],
                         
                             });
                         
                           });
                         </script>
                      </tbody>
                   
                </table>
                </div>
            </div>
        </div>
      
    </div>
</div>

@endsection