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
		         <li class="breadcrumb-item"><a href="/template"><i class="fa far fa-arrow-circle-left"></i> Quản trị</a></li>
		         <li class="breadcrumb-item "><a href="<?php echo e(route('user')); ?>">Danh sách thành viên</a></li>
		         <li class="breadcrumb-item active" href="">Chi tiết thành viên</li>
		       </ol>

				<div class="form-horizontal">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Chi tiết thành viên</h5>


							<div class="heading-elements">
								<ul class="icons-list">	
			                		<a href="../list/"><i class="icon-cross3"></i></a>
			                	</ul>
		                	</div>
							
						</div>

						<div class="panel-heading">
						
						<div class="form-group row">
							<label class="col-lg-2 ">Tên thành viên :</label>
							
								<div class="col-lg-10 "><?php echo isset($data_user) ? $data_user['fullname'] : null; ?>

								
								</div>
							
							<input type="hidden" id="user_id" value="<?php echo isset($data_user) ? $data_user['id'] : null; ?>">
						</div>
						
						<div class="form-group row">
							<label class="col-lg-2">Tên đăng nhập :</label>
							
								<div class="col-lg-10 ">
									<?php echo isset($data_user) ? $data_user['username'] : null; ?>

								</div>
									
							
						</div>
						<div class="form-group row">
							<label class="col-lg-2 ">Emai :</label>
							
								<div class="col-lg-10 ">
									<?php echo isset($data_user) ? $data_user['email'] : null; ?>

								</div>
									
							
						</div><div class="form-group row">
							<label class="col-lg-2 ">Di động :</label>
							
								<div class="col-lg-10 ">
									<?php echo isset($data_user) ? $data_user['mobile'] : null; ?>

								</div>
									
							
						</div>
						
						</div>
					</div>		
				</div>

					<div class="content-header">
		             <div class="panel panel-flat">
		               <ol class="panel-heading">
		                 <div >
		                   <a class="pull-right" href="<?php echo e(route('View_Add_Detail',$data_user['id'])); ?>" ><span class="btn btn-primary"><i class="fa fa-plus-circle fa-fw fa-lg"></i> Thêm thành viên</span> </a>
		                   
							<h5 class="panel-title"> Danh sách thành viên quản lý</h5>
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
		                                  <th>Tên thành viên</th>
		                                  <th>Tên đăng nhập</th>
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
	               	ajax:
	               	({ 
	               	url: "<?php echo e(url('getlist_user_manager',['id'=>$data_user->id])); ?>",
	               	}),
	               
	               	columns: [
                        	{ data: 'stt', name: 'stt' },
	                        { data: 'name', name: 'name' },
	                        { data: 'email', name: 'email' },
	                        { data: 'action', name: 'action',  orderable: false, searchable: false, className : 'text-center', },

	                     ],
                 	"iDisplayLength": 25,
                  	order: [0, 'asc'],
                  	"language": {
                  	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json"
	              				},

	            });
	         });
     			$(document).on('click', '.delete', function(){
	               	var id = $(this).attr("id");
	               	var table = $('#table').DataTable();
	               	table.rows().eq(0).each( function ( index ) {
	                   	var row = table.row( index );
	                   	var data = row.data();
	                   
	                   	if(id == data['id']){
	                   	console.log(data['name']);
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
	                       	url:"<?php echo e(route('delete_user_manager')); ?>",
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