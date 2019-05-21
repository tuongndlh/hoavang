@extends('master')
@section('content')
<html lang="en">
<head>
      <script src="{{ asset('public/js/jquery-3.2.1.js') }}"></script>
      <script src="{{ asset('public/maskmoney/jquery.maskMoney.js') }}"></script>
      <script src="{{ asset('public/js/moment.min.js') }}"></script>
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

                </ol>

                <!-- Lọc -->
                <div class="content-header">
                    <div class="panel panel-flat">
                       <div class="form-group row">
                            <label class="control-label col-sm-1 text-right ">Ngày:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="date_filter" id="date_filter"/>
                            </div>

                           <label class="control-label col-sm-2 text-right ">Tháng:</label>
                          <div class="col-sm-2">
                             <select class="select custom-select" id="month" data-width="100%"  data-placeholder="">
                               <option value="0">Tất cả </option>
                               @foreach ($month as $group_item)
                                     <option value="{{ $group_item->month}}">{{ $group_item->month}}</option>
                                 @endforeach
                             </select>
                          </div>
                          <label class="control-label col-sm-2 text-right ">Trạng thái:</label>
                          <div class="col-md-2">
                            <select class="select custom-select" id="status_fil" data-width="100%"  data-placeholder="">
                              <option value="0">Tất cả </option>
                              <option value="1">Chưa thu tiền</option>
                              <option value="2">Đã thu tiền</option>
                            </select>
                          </div>
                      </div>
                      </div>
                   </div>

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
                                   <th>Tháng</th>
                                   <th>Tiền học</th>
                                   <th>Trang thái</th>
                                 </tr>
                               </thead>
                               <tfoot>
                                   <tr>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td><b>Tổng tiền: </b></td>
                                     <td></td>
                                     <td></td>
                                   </tr>
                                 </tfoot>
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
  $(function () {
        var dateInterval = getQueryParameter('date_filter');
        var start = moment().startOf('isoWeek') ;
        var end = moment().endOf('isoWeek');

        if (dateInterval) {
            dateInterval = dateInterval.split(' - ');
            start =  dateInterval[0];
            end = dateInterval[1];
        }
        $('#date_filter').daterangepicker({
            "showDropdowns": true,
            "showWeekNumbers": true,
            "alwaysShowCalendars": true,
            startDate:  start,
            endDate: end,
            locale: {
                format: 'YYYY-MM-DD',
                firstDay: 1,
            },
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tất cả': [moment().subtract(30, 'year').startOf('month'), moment().endOf('month')],
            }
        });
    });
    function getQueryParameter(name) {
          const url = window.location.href;
          name = name.replace(/[\[\]]/g, "\\$&");
          const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
              results = regex.exec(url);
          if (!results) return null;
          if (!results[2]) return '';
          return decodeURIComponent(results[2].replace(/\+/g, " "));
      }
  $(document).ready(function() {
    $('.select').select2({
              allowClear: true,
            });
      function formatNumber(nStr, decSeperate, groupSeperate) {
                 nStr += '';
                 x = nStr.split(decSeperate);
                 x1 = x[0];
                 x2 = x.length > 1 ? '.' + x[1] : '';
                 var rgx = /(\d+)(\d{3})/;
                 while (rgx.test(x1)) {
                     x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
                 }
                 return x1 + x2;
             }
     function findAndReplace(string, target, replacement) {
       var i = 0, length = string.length;
       for (i; i < length; i++) {
           string = string.replace(target, replacement);
       }
       return string;
     }
         $(function() {
            var t =       $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 "footerCallback": function ( row, data, start, end, display ) {
                   var api = this.api();
                   nb_cols = api.columns().nodes().length - 1;
                   var j = 4;
                   while(j < nb_cols){
                     var pageTotal = api
                           .column( j, { page: 'current'} )
                           .data()
                           .reduce( function (a, b) {
                               return  Number(a) + Number(b);
                           }, 0 );
                     // Update footer
                  // var result =  pageTotal.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
                 var result =   '<b>'+ formatNumber(pageTotal, '.', ',') + '</b>';
                     $( api.column( j ).footer() ).html( result);
                     j++;
                   }
                 },
                // ajax: '{{ route('sumary_ajax') }}',
                ajax: {
                       url :   '{!! route('sumary_ajax') !!}',
                       data: function(d){
                         var date_filter = "'"+ $('#date_filter').val() + "'";
                           d.date =    findAndReplace(date_filter, ' - ', "'"+' and '+"'")
                           d.level =   $('#month').val()
                           d.status_fil =   $('#status_fil').val()
                       }
                   },

                 columns: [
                  { data: 'STT', },
                  { data: 'name_child' },
                  { data: 'name_class', },
                  { data: 'month'},
                  { data: 'amount',className : 'text-right', render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                  { data: 'Status_Money',className : 'text-center',},
                   ],
                  "iDisplayLength": 25,
                   order: [2, 'desc'],
                  "language": {
                    "url": "public/Vietnamese.json"

                },
              });

              t.on( 'order.dt search.dt', function () {
       t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );
   } ).draw();
         $('#month').change(function (e) {
             t.draw();
         });
           $('#date_filter').change(function (e) {
            t.draw();
        });
        $('#status_fil').change(function (e) {
         t.draw();
     });
           });


           // Thu tiền
           $(document).on('click', '.done_money', function(){
               var id = $(this).attr("id");
              // alert(id);
                var table = $('#table').DataTable();
                var data = table.row( $(this).parents('tr') ).data();
            //   console.log(data);
              swal({
                       title: "Bạn chắc chắn thu tiền:",
                       text: data["name_child"],
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
                                    id:id,
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
