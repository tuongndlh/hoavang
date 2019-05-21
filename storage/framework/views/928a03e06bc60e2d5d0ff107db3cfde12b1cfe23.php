<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
      <script src="<?php echo e(asset('public/js/jquery-3.2.1.js')); ?>"></script>
      <script src="<?php echo e(asset('public/maskmoney/jquery.maskMoney.js')); ?>"></script>
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
         <li class="breadcrumb-item active" href="<?php echo e(route('cost')); ?>">Danh sách loại học phí</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <div class="pull-right">
                      <div id="add_data"><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i> Thêm mới</span> </div>
                    </div>
                    <h2 class="panel-title">Khai báo loại học phí</h2>
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
                                   <th>Tên học phí</th>
                                   <th>Tiền học phí</th>
                                   <th>Cập nhật</th>
                                   <th>Tác vụ</th>
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
<div id="group_customer" class="modal fade" role="dialog"  data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
      <form method="POST" id="group_customer_form" enctype="multipart/form-data" >
        <?php echo e(csrf_field()); ?>

        <div class="modal-header  bg-primary">
          <h4 class="modal-title">Thêm mới</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-body-new">

      <div class="form-group row">
        <label class="control-label col-sm-3">Mã nộp tiền <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" readonly class="form-control" name="code" id="code" required="required" placeholder=""   value="">
        </div>
       </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Tên học phí <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="name" id="name" required="required" placeholder="Nhập tên học phí" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Tiền học phí <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control"  type="number" name="price" id="price" required="required" placeholder="Nhập tiền học phí " value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-4">Có hoàn trả</label>
          <div class="col-sm-2">
            <input type="hidden" name="rollback" value="0">
            <input type="checkbox" name="rollback" id="rollback" value="1" >
          </div>
          <label class="control-label col-sm-4">Là học phí</label>
          <div class="col-sm-2">
            <input type="hidden" name="is_cost" value="0">
            <input type="checkbox" name="is_cost" id="is_cost" value="1" >
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Ghi chú <span class="text-danger"></span></label>
          <div class="col-sm-9">
            	<textarea rows="5" cols="5" class="form-control" id="description" name="description" placeholder="Nhập ghi chú" ></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
           <input type="hidden" name="id" id="id" value="" />
          <input type="hidden" name="button_action" id="button_action" value="insert" />
          <button type="submit" onClick="check_type(1)" name="submit" id="action" class="btn btn-primary">Lưu dữ liệu</button>
          <button type="submit" onClick="check_type(2)" name="action_new" id="action_new" class="btn btn-primary" >Lưu & Tạo mới</button>
      </div>
      </form>
        </div>
    </div>
</div>


<script type="text/javascript">
// $("#price").keypress(function(event){
//         // console.log(event.which);
//      if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
//          event.preventDefault();
//      }});
function check_type(type) {
  window.type = type;
}
  setTimeout(function() {
         $(".alert").alert('close');
     }, 10000);

</script>
  <script type="text/javascript">
  $('#price').maskMoney({thousands: ',', decimal: '.', precision: 0});

       $(document).ready(function() {

         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: '<?php echo e(url('cost_ajax')); ?>',
               columns: [
                        // { data: 'id', name: 'id' },
                        { data: 'name' },
                        { data: 'price',className : 'text-right', render: $.fn.dataTable.render.number( ',', '.', 0 ) },
                        { data: 'update_date'},
                        { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
                     ],
                "iDisplayLength": 25,
                order: [2, 'desc'],
                "language": {
                  "url": "public/Vietnamese.json"
              },

            });
         });
         $('#add_data').click(function(){
                $('#group_customer').modal('show');
                $('#group_customer_form')[0].reset();
                $('#form_output').html('');
                $('#button_action').val('insert');
                $('.modal-title').text('Thêm mới');
                $.ajax({
                      url:"<?php echo e("get_code_cost"); ?>",
                      method:"GET",
                      dataType:"JSON",
                      success:function(data)
                      {
                        $('#code').val(data[0]);
                      }
                    });
            });
            // Them du lieu
            $('#group_customer_form').on('submit', function(event){
                 event.preventDefault();
                 $.ajax({
                  url:"<?php echo e(route('add_cost')); ?>",
                  method:"POST",
                  data:new FormData(this),
                  dataType:'JSON',
                  contentType: false,
                  cache: false,
                  processData: false,
                  success:function(data)
                  {
                   $('#group_customer_form').html(data.success);
                   $('#group_customer_form')[0].reset();
                 //  $('form[name=group_customer_form]').get(0).reset();
                   $('.modal-title').text('Thêm mới');
                   $('#button_action').val('insert');
                   $('#table').DataTable().ajax.reload();
                   if(window.type == 1 ){
                     $('#group_customer').modal('hide');
                   }
                  }
                 })
                });

                // Sửa
                $(document).on('click', '.edit', function(){
                    var id = $(this).attr("id");
                    window.id = $(this).attr("id");
                    $('#id').val(id);
                    //  $('#form_output').html('');
                    $.ajax({
                        url:"<?php echo e(route('edit_cost')); ?>",
                        method:'GET',
                        data:{id:id, _token: '<?php echo e(csrf_token()); ?>'},
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
                           url:"<?php echo e(route('delete_cost')); ?>",
                           method:'GET',
                           data:{id:id, _token: '<?php echo e(csrf_token()); ?>'},
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>