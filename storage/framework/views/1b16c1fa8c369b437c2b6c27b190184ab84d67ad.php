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
         <li class="breadcrumb-item active" href="<?php echo e(route('child')); ?>">Danh sách các cháu</li>
       </ol>
          <div class="content-header">
             <div class="panel panel-flat">
               <ol class="panel-heading">
                 <div >

                    <div class="pull-right">
                      <!-- <div id="transfer">
                        <span class="btn btn-primary">
                        <i class="fas fa-exchange-alt"></i>  Chuyển lớp</span> -->


                        <a href="<?php echo e(route('view_child')); ?>"> <span class="btn btn-primary">
                          <i class="fa fa-plus-circle fa-fw fa-lg"></i> Thêm mới</a> </span>
                      </div>


                    <!-- </div> -->
                    <h2 class="panel-title">Khai báo các cháu</h2>
                 </div>
               </ol>
               <div class="content-header">
                   <div class="panel panel-flat">
                      <div class="form-group row">
                         <label class="control-label col-sm-2 text-right ">Lọc theo lớp:</label>
                          <div class="col-sm-2">
                          <select class="select custom-select" id="name_class" data-width="100%"  data-placeholder="">

                            <option value="0">Tất cả </option>
                            <?php $__currentLoopData = $class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($group_item->id); ?>"><?php echo e($group_item->name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                   <th>Địa chỉ</th>
                                   <th>SDT</th>
                                   <th>Lớp</th>
                                   <th>Loại phí</th>
                                   <th>Cập nhật</th>
                                   <th>Tác vụ</th>
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
      <form method="POST" id="group_customer_form" >
        <div class="modal-header  bg-primary">
          <h4 class="modal-title">Thêm mới</h4>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-body-new">

        <div class="form-group row">
          <label class="control-label col-sm-3">Từ lớp <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="from_class" id="from_class" required="required" placeholder="Nhập tên lớp" value="">
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3">Đến lớp <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="to_class" id="to_class" required="required" placeholder="Nhập tên lớp" value="">
          </div>
        </div>

      </div>
      <div class="modal-footer">
          <input type="hidden" name="name_delete" id="name_delete" value="" />
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

  $(document).ready(function() {
    $('.select').select2({
              allowClear: true,
              //minimumResultsForSearch: Infinity,
            });
           $(function() {
              var allUsersTable =   $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                // ajax: '<?php echo e(url('child_ajax')); ?>',
                ajax: {
                       url :   '<?php echo url('child_ajax'); ?>',
                       data: function(d){
                           d.level =   $('#name_class').val()
                       }
                   },

                 columns: [
                   { data: 'STT', },
                  { data: 'namechild' },
                  { data: 'address' },
                  { data: 'mobile' },
                  { data: 'classname', },
                  { data: 'fee', },
                  { data: 'update_date'},
                  { data: 'status',visible:false},
                  { data: 'action', name: 'action', orderable: false, searchable: false, className : 'text-center', }
                         ],
                  "iDisplayLength": 25,
                  order: [7, 'desc'],
                  "language": {
                    "url": "public/Vietnamese.json"

                },
              });
              $('#name_class').change(function (e) {
            allUsersTable.draw();
        });
           });
           $('#transfer').click(function(){

                   $('#group_customer').modal('show');
                  // $('#group_customer_form')[0].reset();
                  // $('#form_output').html('');
                  // $('#button_action').val('insert');
                  // $('.modal-title').text('Thêm mới');
              });
                  //Xóa
                  $(document).on('click', '.delete', function(){
                     var id = $(this).attr("id");
                     var table = $('#table').DataTable();
                     table.rows().eq(0).each( function ( index ) {
                         var row = table.row( index );
                         var data = row.data();
                         if(id == data['id']){
                         //console.log(data['type_']);
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
                             url:"<?php echo e(route('delete')); ?>",
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