<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
        <script src="<?php echo e(asset('public/js/jquery-3.2.1.js')); ?>"></script>
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
         <li class="breadcrumb-item active" href="<?php echo e(route('class')); ?>">Danh sách lớp</li>
       </ol>

          <div class="col-md-12">

          <div class="content-header">
               <div class="panel panel-flat">
                 <ol class="panel-heading">
                   <div >
                      <div class="pull-right">
                        <div class="pull-right">
                          <div id="add_data"><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i> Thêm mới</span> </div>
                        </div>

                      </div>
                      <h5 class="panel-title">Khai báo lớp</h5>
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
                                     <th>Tên lớp</th>
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
               <!-- /.panel-body -->
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
        <label class="control-label col-sm-3">Mã lớp <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <input type="text" readonly class="form-control" name="code" id="code" required="required" placeholder=""   value="">
        </div>
       </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Tên lớp <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="name" id="name" required="required" placeholder="Nhập tên lớp" value="">
          </div>
        </div>
        <div class="form-group row">
                 <label class="control-label col-sm-3">Học phí<span class="text-danger">*</span></label>
                   <div class="col-sm-9">
                   <select class="select form-control"   data-width="100%"
                           name="fee" id="fee" data-placeholder="Chọn học phí">
                     <option ></option>
                     <?php $__currentLoopData = $cost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($group_item->id == old('dept')): ?>
                          <option value="<?php echo e($group_item->id); ?>" selected=selected ><?php echo e($group_item->name); ?>

                          - <?php echo e($group_item->price); ?></option>
                        <?php else: ?>
                          <option value="<?php echo e($group_item->id); ?>"><?php echo e($group_item->name); ?> - <?php echo e($group_item->price); ?>

                          </option>
                        <?php endif; ?>

                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>
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
          $('#fee').append(new Option());
         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: '<?php echo e(url('class_ajax')); ?>',
               columns: [
                        // { data: 'id', name: 'id' },
                        { data: 'name' },
                        { data: 'price', render: $.fn.dataTable.render.number( ',', '.', 0 ) },
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
                      url:"<?php echo e("get_code"); ?>",
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
                    var code = $("#code").val();
                    var name = $("#name").val();
                    var fee = $("#fee").val();
                    var description = $("#description").val();
                    var button_action = $("#button_action").val();
                    var id =  window.id;

                  //  alert(window.type);
                    $.ajax({
                        url:"<?php echo e(route('add_class')); ?>",
                        method:"POST",
                        data:{
                          id:id,
                          code:code,
                          name:name,
                          fee:fee,
                          description:description,
                          button_action:button_action,
                          _token: '<?php echo e(csrf_token()); ?>'
                        },
                        dataType:"JSON",
                        success:function(data)
                        {
                          // console.log(data[0]);
                                $('#form_output').html(data.success);
                                $('#group_customer_form')[0].reset();
                                $('.modal-title').text('Thêm mới');
                                $('#button_action').val('insert');
                                $('#table').DataTable().ajax.reload();
                                $('#code').val(data[0]);
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
                        url:"<?php echo e(route('edit_class')); ?>",
                        method:'GET',
                        data:{id:id, _token: '<?php echo e(csrf_token()); ?>'},
                        dataType:'JSON',
                        success:function(data)
                        {
                          $("#fee").html(data[0].fee);
                          $.each(data[1], function () {
                                          if(data[0].fee == this.id){
                                                $("#fee").append(
                                                    '<option value="'+this.id+'" selected >'
                                                    +this.name+' - '+this.price+'</option>'
                                                  )
                                              }
                                          else {
                                                  $("#fee").append(
                                                    '<option value="'+this.id+'">'+this.name+
                                                    ' - '+ this.price +'</option>'
                                                  )
                                                }
                                      });

                            $('#name').val(data[0].name);
                            $('#code').val(data[0].code);
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
                     // console.log(data);
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
                           url:"<?php echo e(route('delete_class')); ?>",
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