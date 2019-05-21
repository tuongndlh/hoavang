<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
        <script src="//code.jquery.com/jquery.js"></script>
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
         <li class="breadcrumb-item"><a href="/linkhouse"><i class="fa far fa-arrow-circle-left"></i> Trang chủ</a></li>
         <li class="breadcrumb-item active" href="<?php echo e(route('department')); ?>">Danh sách bộ phận</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >
                    <div class="pull-right">
                      <div id="add_data"><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i> Thêm mới</span> </div>
                    </div>
                    <h2 class="panel-title">Khai báo bộ phận</h2>
                 </div>
                </ol>
             </div>
          </div>

             <div class="panel-body">
                 <div class="table-responsive">
                   <div class="container-fluid">
                     	<div class="animate fadeIn">
                         <div class="panel-body">
                          <table width="100%" class="box table table-striped table-hover display responsive nowrap m-t-0" cellspacing="0" id="table">
                            <thead>
                              <tr>
                                  <th>Tên bộ phận</th>
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
             <!-- /.panel-body -->

      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<div id="group_customer" class="modal fade" role="dialog"  data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
      <form method="POST" id="group_customer_form" >
        <div class="modal-header  bg-primary">
          <h4 class="modal-title">Thêm mới</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-body-new">
        <div class="form-group row">
          <label class="control-label col-sm-3">Tên bộ phận <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="name" id="name" required="required" placeholder="Nhập bộ phận" value="">
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
          <!-- <input type="hidden" name="group_id" id="group_id" value="" /> -->
          <input type="hidden" name="button_action" id="button_action" value="insert" />
          <button type="submit" onClick="check_type(1)" name="submit" id="action" class="btn btn-primary">Lưu dữ liệu</button>
          <button type="submit" onClick="check_type(2)" name="action_new" id="action_new" class="btn btn-primary" >Lưu & Tạo mới</button>
      </div>
      </form>
        </div>
    </div>
</div>


<script type="text/javascript">
function check_type(type) {
  window.type = type;
}
  setTimeout(function() {
         $(".alert").alert('close');
     }, 10000);

</script>
  <script type="text/javascript">
       $(document).ready(function() {

         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: '<?php echo e(url('dept_ajax')); ?>',
               columns: [
                        // { data: 'id', name: 'id' },
                        { data: 'name' },
                        { data: 'update_date'},
                        { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
                     ],
                "iDisplayLength": 25,
                order: [1, 'desc'],
                "language": {
                  "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
              },

            });
         });
         $('#add_data').click(function(){
                $('#group_customer').modal('show');
                $('#group_customer_form')[0].reset();
                $('#form_output').html('');
                $('#button_action').val('insert');
                $('.modal-title').text('Thêm mới');
            });
            // Them du lieu
               $('#group_customer_form').on('submit', function(event){
                    event.preventDefault();
                    var name = $("#name").val();
                    var description = $("#description").val();
                    var button_action = $("#button_action").val();
                    var id =  window.id;
                  //  alert(window.type);
                    $.ajax({
                        url:"<?php echo e(route('add_department')); ?>",
                        method:"POST",
                        data:{
                          id:id,
                          name:name,
                          description:description,
                          button_action:button_action,
                          _token: '<?php echo e(csrf_token()); ?>'
                        },
                        dataType:"JSON",
                        success:function(data)
                        {
                          //console.log(data[0]);
                                $('#form_output').html(data.success);
                                $('#group_customer_form')[0].reset();
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
                    window.id = $(this).attr("id");;
                    $('#form_output').html('');
                    $.ajax({
                        url:"<?php echo e(route('edit_department')); ?>",
                        method:'GET',
                        data:{id:id, _token: '<?php echo e(csrf_token()); ?>'},
                        dataType:'JSON',
                        success:function(data)
                        {
                            $('#name').val(data.name);
                            $('#description').val(data.description);
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
                       window.name = data['name'];
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
                           url:"<?php echo e(route('delete_department')); ?>",
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