@extends('master')
@section('content')
<html lang="en">
<head>
      <script src="{{ asset('public/js/jquery-3.2.1.js') }}"></script>
      <script src="{{ asset('public/maskmoney/jquery.maskMoney.js') }}"></script>
</head>

<body>

<section class="content">
    <div class="row">
      <div class='notifications text-right'></div>
        <span class="alert alert-success" role="alert" style="display:none" ></span>
      </div>
      <div class="col-md-12">

        <ol class="breadcrumb">
         <!-- <li class="breadcrumb-item">Home</li> -->
         <li class="breadcrumb-item"><a href="/hoahong"><i class="fa far fa-arrow-circle-left"></i> Trang chủ</a></li>
         <li class="breadcrumb-item active" href="{{route('child')}}">Danh sách tiền học các lớp</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <h2 class="panel-title">Thu tiền học theo tháng: <b>{!!  date('m-Y') !!}</b></h2>
                 </div>
                </ol>

                <div class="panel-body">
                    <div class="table-responsive">
                      <div class="container-fluid">
                         <div class="animate fadeIn">
                            <div class="panel-body">
                             <table width="100%" class="display nowrap" style="width:100%" cellspacing="0" id="table">
                               <thead>
                                 <tr>
                                   <th> STT </th>
                                   <th>Tên cháu</th>
                                   <th>Lớp học</th>
                                   <th>Tổng tiền học</th>
                                   <th>Ngày nghỉ</th>
                                   <th>Miễn giảm</th>
                                   <th>Còn lại</th>
                                   <th>Ghi chú</th>
                                   <th>Thu tiền</th>
                                   <th></th>
                                 </tr>
                               </thead>
                             </table>
                           </div>
                        </div>
                       </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
             </div>
          </div>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

  <script type="text/javascript">

  $(document).ready(function() {

           $(function() {
            var t =       $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: '{{ route('sumary_ajax') }}',

                 columns: [
                  { data: 'STT', },
                  { data: 'name' },
                  { data: 'name_class', },
                  { data: 'amount', class:'amount',render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                  { data: 'amount_dayoff'},
                  { data: 'discount', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'sum_amount', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'description'},
                  { data: 'done_money'},
                  { data: 'update_date',visible:false},

                   ],
                  "iDisplayLength": 25,
                   order: [2, 'desc'],
                  "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"

                },
              });

              t.on( 'order.dt search.dt', function () {
       t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );
   } ).draw();

           });


           // Thu tiền
           $(document).on('click', '.done_money', function(){
                var table = $('#table').DataTable();
                var data = table.row( $(this).parents('tr') ).data();

                var child_id =data["child_id"];
                var sum_amount =data["amount"];
                var day_off =data["dayoff"];
                var month =data["month"];
                var discount =data["discount"];
                var total_amount =data["sum_amount"];
            //   console.log(data);
              swal({
                       title: "Bạn chắc chắn thu tiền:",
                       text: data["name"],
                       icon: "warning",
                       buttons: true,
                       dangerMode: true,
                   })
                   .then((willDelete) => {
                      if (willDelete) {
                        $.ajax({
                                  url:"{{ route('add_data_total') }}",
                                  method:"post",
                                  data:{
                                    child_id:child_id,
                                    sum_amount:sum_amount,
                                    day_off:day_off,
                                    month:month,
                                    discount:discount,
                                    total_amount:total_amount,
                                   _token: '{{csrf_token()}}'
                                  },
                                  dataType:"json",
                                  success:function(data)
                                  {
                                    $('#table').DataTable().ajax.reload();
                                  }
                              })
                      }
                    })


           });
         })


         </script>

   </body>
</html>
@endsection
