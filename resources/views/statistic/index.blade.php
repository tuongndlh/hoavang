@extends('master')
@section('content')
<html lang="en">
<head>
      <script src="{{ asset('public/js/jquery-3.2.1.js') }}"></script>
      <script src="{{ asset('public/maskmoney/jquery.maskMoney.js') }}"></script>
      <style>
      .title {
        border-style: solid;
        border-color: coral;
      }

      /* div {
        border-style: solid;
        border-color: coral;
      } */
      </style>
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
         <li class="breadcrumb-item active" href="{{route('child')}}">Thống kê & In phiếu</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <h2 class="panel-title">Thống kê chi tiết tiền học</h2>
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
                                   <th></th>
                                   <th>In phiếu</th>
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
<!-- <div id="print_report" class="modal fade" role="dialog"  data-backdrop="false">
  MẪU GIÁO HOA HỒNG

</div> -->

<div  id="print_report" class="modal fade" data-backdrop="false">
  <fieldset style="margin-top:-10px;margin-left:-7px;margin-right:-7px;">
    <div class="row" >
    <div style="text-align:center;">
        <b><h3> MẪU GIÁO HOA HỒNG </h3></b>
    </div>
    <div style="text-align:center; margin-top:-3px;">
      THÔNG BÁO THU TIỀN THÁNG <b> {!!date('m')!!} / {!!date('Y')!!}</b>
    </div>
    <div style="margin-top:3px;">
      Kính gởi phụ huynh cháu: <b> <label id="name_child" name="name_child"/></b>
    </div>
    <div style="margin-top:5px;">
      Học lớp:  <b><label id="name_class" name="name_child"/></b>
    </div>
    <div style="margin-top:5px;" >
      Tiền học phí:  <b> <label id="price" name="price"/></b>
    </div>
    <div  style="margin-left:30px;margin-top:5px; ">
      <div id="fee"></div>
    </div>
    <div style="margin-top:5px;">
      Tiền nghỉ:  <b><label id="money_day_off" name="money_day_off"/></b>
    </div>
    <div style="margin-top:5px;">
      Tổng tiền: <b><label id="total_amount" name="total_amount"/></b>
    </div>
    <div style="text-align:right;">
      <i>Ngày {!!date('d')!!}  tháng {!!date('m')!!}  năm {!!date('Y')!!}</i>
    </div>
    <div style="text-align:right; margin:5px; margin-right:50px; margin-bottom:50px;">
      Chủ nhóm
    </div>
  </div>
</fieldset>
</div>
<!-- /.content -->


  <script type="text/javascript">

  $(document).ready(function() {

           $(function() {
            var t =       $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: '{{ route('statistic_ajax') }}',

                 columns: [
                  { data: 'STT', },
                  { data: 'name_child' },
                  { data: 'name_class', },
                  { data: 'sum_amount', render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                  { data: 'day_off'},
                  { data: 'discount', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'total_amount', render: $.fn.dataTable.render.number( ',', '.', 0 )},
                  { data: 'update_date',visible:false},
                  { data: 'print'},
                   ],

                    "iDisplayLength": 25,
                   order: [7, 'desc'],
                  "language": {
                    "url": "public/Vietnamese.json"
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
                var divToPrint=document.getElementById('print_report');
                var newWin=window.open('','Print-Window');
                        $.ajax({
                                  url:"{{ route('Print_report') }}",
                                  method:"post",
                                  data:{
                                    child_id:child_id,
                                   _token: '{{csrf_token()}}'
                                  },
                                  dataType:"json",
                                  success:function(data)
                                  {
                                    // console.log(data[0]);
          var money_day_off = data[4] == 0 ? '' : data[4]+' ( '+ data[0][0].day_off +' ngày )';
                                     $('#name_child').html(data[0][0].name_child);
                                     $('#name_class').html(data[0][0].name_class);
                                     $('#price').html(data[2]);
                                     $('#total_amount').html(data[3]);
                                     $("#fee").html(data[1]);
                                     $("#money_day_off").html(money_day_off);

                                    newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                                    newWin.document.close();
                                    setTimeout(function(){newWin.close();},10);
                                  }
                              })


                      //   setTimeout(function(){newWin.close();},10);

           });
         })

         function printDiv(print_report)
          {
           //console.log(window.child_id);
           // var divToPrint=document.getElementById('print_report');
           //  var newWin=window.open('','Print-Window');
            // newWin.document.open();
            // newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            // newWin.document.close();
            // setTimeout(function(){newWin.close();},10);

          }

         function openPrintDialogue(){
           var table = $('#table').DataTable();
           var data = table.row( $(this).parents('tr') ).data();
          // console.log(data);
         //  var child_id =data["child_id"];
           $('<iframe>', {
             name: 'myiframe',
             class: 'printFrame'
           })
           .appendTo('body')
           .contents().find('body')
           .append('');

           window.frames['myiframe'].focus();
           window.frames['myiframe'].print();

           setTimeout(() => { $(".printFrame").remove(); }, 1000);
         };

         </script>

   </body>
</html>
@endsection
