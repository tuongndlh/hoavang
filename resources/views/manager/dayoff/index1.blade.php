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
         <li class="breadcrumb-item active" href="{{route('child')}}">Danh sách các cháu</li>
       </ol>
          <form method="post" id="upload_form" action="{{url('validation')}}"  enctype="multipart/form-data">
             {{ csrf_field() }}
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <div class="pull-right">
                        <button type="submit"
                         name="submit" id="action" class="btn btn-primary">
                         <i class="fa fa-plus-circle fa-fw fa-lg"></i>Lưu dữ liệu</button>
                    </div>
                    <h2 class="panel-title">Nhập chi tiết trong tháng hiện tại</h2>
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
                                   <th>Lớp</th>
                                   <th>Ngày nghỉ</th>
                                   <th>Miễn giảm</th>
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
          </form>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->


  <script type="text/javascript">
  $('#discount').maskMoney({thousands: ',', decimal: '.', precision: 0});
  $(document).ready(function() {

           $(function() {
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: '{{ url('dayoff_ajax') }}',

                 columns: [
                  { data: 'STT', },
                  { data: 'namechild' },
                  { data: 'classname', },
                  { data: 'dayoff',name: 'dayoff'},
                  { data: 'discount'},
                         ],
                  "iDisplayLength": 25,
                //  order: [0, 'desc'],
                  "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"

                },
              });

           });
           // Upload images
              $('#upload_form').on('submit', function(event){
                  event.preventDefault();
                  var dayoff =  $('#dayoff').val();
                  console.log(dayoff);

                  $.ajax({
                      url:"{{ route('save_data') }}",
                      method:"POST",
                      data:{
                        dayoff:dayoff,                        
                        _token: '{{csrf_token()}}'
                      },
                      dataType:"JSON",
                      success:function(data)
                      {
                        //console.log(data[0]);

                              $('#table').DataTable().ajax.reload();

                      }
                  })


                 });
         })
       // $(document).ready(function() {
       //
       //   $(function() {
       //      //    $('#table').DataTable({
       //      //    processing: true,
       //      //    serverSide: true,
       //      //    ajax: '{{ url('child_ajax') }}',
       //      //    columns: [
       //      //             { data: 'STT', },
       //      //             { data: 'name' },
       //      //             { data: 'class', },
       //      //             { data: 'fee', },
       //      //             { data: 'update_date'},
       //      //             { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
       //      //          ],
       //      //     "iDisplayLength": 25,
       //      //     order: [3, 'desc'],
       //      //     "language": {
       //      //       "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
       //      //   },
       //      //
       //      // });
       //      $('#table').DataTable({
       //    processing: true,
       //    serverSide: true,
       //    ajax: '{{ url('child_ajax') }}',
       //
       //    columns: [
       //               { data: 'STT', },
       //               { data: 'name' },
       //               { data: 'class', },
       //               { data: 'fee', },
       //               { data: 'update_date'},
       //               { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
       //            ],
       //      columnDefs: [
       //      {
       //          render: function (data, type, full, meta) {
       //              return "<div class='text-wrap width-200'>" + data + "</div>";
       //          },
       //          targets: 3
       //      }
       // ],
       //     "iDisplayLength": 25,
       //     order: [3, 'desc'],
       //     "language": {
       //       "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
       //
       //   },
       // });
       //   });
       //   $('#add_data').click(function(){
       //          $('#group_customer').modal('show');
       //          $('#group_customer_form')[0].reset();
       //          $('#form_output').html('');
       //          $('#button_action').val('insert');
       //          $('.modal-title').text('Thêm mới');
       //          $.ajax({
       //                url:"{{"get_code_child"}}",
       //                method:"GET",
       //                dataType:"JSON",
       //                success:function(data)
       //                {
       //                  $('#code').val(data[0]);
       //                }
       //              });
       //      });
       //      // Them du lieu
       //         $('#group_customer_form').on('submit', function(event){
       //              event.preventDefault();
       //              var code = $("#code").val();
       //              var name = $("#name").val();
       //              var price = $("#price").val();
       //              var description = $("#description").val();
       //              var button_action = $("#button_action").val();
       //              var id =  window.id;
       //            //  alert(window.type);
       //              $.ajax({
       //                  url:"{{ route('/') }}",
       //                  method:"POST",
       //                  data:{
       //                    id:id,
       //                    code:code,
       //                    name:name,
       //                    price:price,
       //                    description:description,
       //                    button_action:button_action,
       //                    _token: '{{csrf_token()}}'
       //                  },
       //                  dataType:"JSON",
       //                  success:function(data)
       //                  {
       //                    //console.log(data[0]);
       //                          $('#form_output').html(data.success);
       //                          $('#group_customer_form')[0].reset();
       //                          $('.modal-title').text('Thêm mới');
       //                          $('#button_action').val('insert');
       //                          $('#table').DataTable().ajax.reload();
       //                          if(window.type == 1 ){
       //                            $('#group_customer').modal('hide');
       //                          }
       //                  }
       //              })
       //          });
       //          // Sửa
       //          $(document).on('click', '.edit', function(){
       //              var id = $(this).attr("id");
       //              window.id = $(this).attr("id");;
       //              $('#form_output').html('');
       //              $.ajax({
       //                  url:"{{route('/')}}",
       //                  method:'GET',
       //                  data:{id:id, _token: '{{csrf_token()}}'},
       //                  dataType:'JSON',
       //                  success:function(data)
       //                  {
       //                      $('#code').val(data.code);
       //                      $('#name').val(data.name);
       //                      $('#price').val(data.price);
       //                      $('#description').val(data.description);
       //                      $('#group_customer').modal('show');
       //                      $('#action').val('Edit');
       //                      $('.modal-title').text('Sửa dữ liệu');
       //                      $('#button_action').val('update');
       //                  }
       //              })
       //          });
       //          //Xóa
       //          $(document).on('click', '.delete', function(){
       //             var id = $(this).attr("id");
       //             var table = $('#table').DataTable();
       //             table.rows().eq(0).each( function ( index ) {
       //                 var row = table.row( index );
       //                 var data = row.data();
       //                 if(id == data['id']){
       //                 //console.log(data['name']);
       //                 window.name = data['name_delete'];
       //               }
       //             } );
       //             swal({
       //                 title: "Bạn thật sự muốn xóa:",
       //                 text: window.name,
       //                 icon: "warning",
       //                 buttons: true,
       //                 dangerMode: true,
       //             })
       //             .then((willDelete) => {
       //                 if (willDelete) {
       //                   $.ajax({
       //                     url:"{{route('/')}}",
       //                     method:'GET',
       //                     data:{id:id, _token: '{{csrf_token()}}'},
       //                     dataType:'JSON',
       //                     success:function(data)
       //                     {
       //                       $('#table').DataTable().ajax.reload();
       //                     }
       //                   })
       //                     swal("Đã xóa!", {
       //                         icon: "success",
       //                     });
       //                 }
       //             });
       //
       //          })
       // })

         </script>

   </body>
</html>
@endsection
