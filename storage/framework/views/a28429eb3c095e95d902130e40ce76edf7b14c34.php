<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
        <script src="//code.jquery.com/jquery.js"></script>
</head>
	<body>
		<section class="content">
		    <div class="row">
		      <div class="col-md-12">
		        <ol class="breadcrumb">
		         <!-- <li class="breadcrumb-item">Home</li> -->
		         <li class="breadcrumb-item"><a href="/linkhouse"><i class="fa far fa-arrow-circle-left"></i> Quản trị</a></li>
		         <li class="breadcrumb-item active" href="">Danh sách thành viên</li>
		       </ol>
		          <!-- <div class="content-header">
		             <div class="panel-heading">
		               <ol class="button-header">
		                 <div class="pull-right">
		                   <a href="<?php echo e(route('user.create')); ?>" ><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i> Tạo mới</span> </a>
		                 </div>
		                </ol>
		             </div>
		          </div> -->
      <div class="content-header">
         <div class="panel panel-flat">
           <ol class="panel-heading">
             <div >
                <div class="pull-right">
                  <a href="<?php echo e(route('user.create')); ?>" ><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i> Tạo mới</span> </a>
                </div>
                <h5 class="panel-title">Khai báo nhân viên</h5>
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
		                                  <th>STT</th>
		                                  <th>Kích hoạt</th>
		                                  <th>Tên thành viên</th>
		                                  <th>Tên đăng nhập</th>
		                                  <th>Số người quản lý</th>
		                                  <th>Nhóm thành viên</th>
		                                  <th>Chức vụ</th>
		                                  <th>Phân quyền</th>
		                                  <th>Đăng nhập lần cuối</th>
		                                  <th>Tác vụ</th>


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



		             <!-- /.modal add -->


		             <!-- /.modal edit -->


		      </div>
		      <!-- /.col-lg-12 -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->

       <script>
       	$(document).ready(function() {
	         $(function() {
	               $('#table').DataTable({
	               processing: true,
	               serverSide: true,
	               ajax: '<?php echo e(url('getlist_user')); ?>',
	               columns: [
	               			{ data: 'stt', name: 'stt', className : 'text-center'},
	                        { data: 'locked', name: 'locked' , className : 'text-center'},
	                        { data: 'fullname', name: 'fullname' },
	                        { data: 'email', name: 'email' },
	                        { data: 'count', name: 'count' , className : 'text-center'},
	                        { data: 'department', name: 'department' , className : 'text-center'},
	                        { data: 'position', name: 'position' , className : 'text-center'},
	                        { data: 'permission', name: 'permission' , className : 'text-center'},
	                        { data: 'lastvisited', name: 'lastvisited' , className : 'text-center'},
	                        { data: 'action', name: 'action',  orderable: false, searchable: false, className : 'text-center', },

	                     ],
	                 "iDisplayLength": 25,
	                  order: [0, 'asc'],
	                  "language": {
	                  "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
	              				},

	            });
	         });
     	})


     	</script>
   	</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>