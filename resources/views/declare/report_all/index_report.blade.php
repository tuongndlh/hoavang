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
         <li class="breadcrumb-item active" href="{{route('reportall')}}">Danh mục báo cáo</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div class="col-md-10">
                    <div class="form-group row">
                      <div class="col-md-3">
                        <div class="col-md-4 text-right">
                          <label> Theo tháng: </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control input_date" name="input_date_month" id="input_date_month" placeholder="Theo tháng" />
                        </div>
                      </div>
                      </div>
                    <h2 class="panel-title">Khai báo danh mục báo cáo</h2>
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
                                   <th>STT</th>
                                   <th>Nội dung</th>
                                   <th>Số lượng</th>
                                   <th>Cập nhật</th>
                                   <!-- <th>Tác vụ</th> -->
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

function check_type(type) {
  window.type = type;
}
  setTimeout(function() {
         $(".alert").alert('close');
     }, 10000);

</script>
  <script type="text/javascript">
  $('#quantity').maskMoney({thousands: ',', decimal: '.', precision: 0});

  $("#quantity_input").keypress(function(event){
          // console.log(event.which);
       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault();
   }});
       $(document).ready(function() {
         $('#input_date_month').datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose:true,
        });
         $('.select').select2({
                    allowClear: true,
                    //minimumResultsForSearch: Infinity,
                  });
         $(function() {
          var table =     $('#table').DataTable({

               processing: true,
               serverSide: true,
               ajax: {
                        url : '{!! url('view_reportall_ajax') !!}',
               data: function(d){
                          var input_date_month = $('#input_date_month').val();
                          d.input_date_month =    input_date_month;
                      },
                    },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name_content' },
                        { data: 'quantity'},
                        { data: 'update_date'},
                      //  { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
                     ],

                "iDisplayLength": 251,
                order: [0, 'asc'],
                "language": {
                  "url": "public/Vietnamese.json"
              },

            });
            $('#input_date_month').change(function (e) {
               table.draw();
           });

            $('#table tbody').on( 'keyup', '.quantity', function () {
                   var data = table.row( $(this).parents('tr') ).data();
                   var oTable = $('#table').DataTable();
                   var datatable = table
                               .rows()
                               .data();
                    for (var i=0; i < datatable.length ;i++){
                      if(i == data['id'] ){
                        $('#quantity'+i).maskMoney({thousands: ',', decimal: '.', precision: 0});
                        $('#quantity'+i).keypress(function(event){
                                // console.log(event.which);
                             if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                                 event.preventDefault();
                             }});


                        var value =$('#quantity'+i).val();
                        var button_action = $("#button_action").val();
                         //console.log(i,value);
                                 $.ajax({
                                     url:"{{ route('add_reportall') }}",
                                     method:"POST",
                                     data:{
                                       id:i,
                                       value:value,
                                       button_action:button_action,
                                       _token: '{{csrf_token()}}'
                                     },
                                     dataType:"JSON",
                                     success:function(data)
                                     {
                                        console.log(data);
                                     }
                                 })
                      }
                    }
               } );

          })


         $('#add_data').click(function(){
                $('#group_customer').modal('show');
                $('#group_customer_form')[0].reset();
                $('#form_output').html('');
                $('#button_action').val('insert');
                $('.modal-title').text('Thêm mới');

            });


                // Sửa
                $(document).on('click', '.edit', function(){
                    var id = $(this).attr("id");
                    window.id = $(this).attr("id");
                    $('#id').val(id);
                    //  $('#form_output').html('');
                    $.ajax({
                        url:"{{route('edit_reportall')}}",
                        method:'GET',
                        data:{id:id, _token: '{{csrf_token()}}'},
                        dataType:'JSON',
                        success:function(data)
                        {
                           //console.log(data[0]);
                            $('#code').val(data[0].code);
                            $('#name').val(data[0].name);
                            $('#price').val(data[0].price);
                          //  $('#rollback').val(data[0].rollback);
                          //  $('#is_cost').val(data[0].is_cost);

                            if(data[0].rollback == 1){
                                  $("#rollback").prop("checked", true);
                              }else{  $("#rollback").prop("checked", false);}

                            if(data[0].is_cost == 1){
                                  $("#is_cost").prop("checked", true);
                              }else{  $("#is_cost").prop("checked", false);}

                            $('#description').val(data[0].description);
                            $('#group_customer').modal('show');
                            $('#action').val('Edit');
                            $('.modal-title').text('Sửa dữ liệu');
                            $('#button_action').val('update');
                        }
                    })
                });
                //Xóa
                $(document).on('click', '.delete', function(){
                   var id = $(this).attr("id");
                   var table = $('#table').DataTable();
                   table.rows().eq(0).each( function ( index ) {
                       var row = table.row( index );
                       var data = row.data();
                       if(id == data['id']){
                       //console.log(data['name']);
                       window.name = data['name_delete'];
                     }
                   } );
                   swal({
                       title: "Bạn thật sự muốn xóa:",
                       text: window.name,
                       icon: "warning",
                       buttons: true,
                       dangerMode: true,
                   })
                   .then((willDelete) => {
                       if (willDelete) {
                         $.ajax({
                           url:"{{route('delete_reportall')}}",
                           method:'GET',
                           data:{id:id, _token: '{{csrf_token()}}'},
                           dataType:'JSON',
                           success:function(data)
                           {
                             $('#table').DataTable().ajax.reload();
                           }
                         })
                           swal("Đã xóa!", {
                               icon: "success",
                           });
                       }
                   });

                })
       })

         </script>

   </body>
</html>
@endsection
