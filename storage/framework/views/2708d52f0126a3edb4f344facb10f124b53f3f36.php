<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
	<script src="<?php echo e(asset('public/js/jquery-3.2.1.js')); ?>"></script>
</head>
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
		         <li class="breadcrumb-item"><a href="/hoahong"><i class="fa far fa-arrow-circle-left"></i>Trang chủ</a></li>
 					 	 <li class="breadcrumb-item"><a href="<?php echo e(route('child')); ?>">Danh sách cháu</a></li>
		         <li class="breadcrumb-item active" href="">Khai báo danh sách các cháu</li>
		       </ol>

		        <!-- <div class="panel-body"> -->


				<form method="POST"action="<?php echo e(Route('add_child')); ?>" >
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Thêm cháu</h4>
							</div>

							<div class="panel-heading" >
								<div class="form-group row">
									<label class="col-lg-3 control-label">Mã code <span class="text-danger">*</span></label>
										<div class="col-lg-3">
										<input type="text" readonly class="form-control" id="code" name="code" value="<?php echo e($code); ?>" >
									</div>
								</div>
								<div class="form-group row <?php echo e($errors->has('promotion_id') ? ' has-error' : ''); ?>">
									<label class="col-lg-3 control-label">Tên cháu <span class="text-danger">*</span></label>
									<div class="col-lg-3 ">
									<input type="text" class="form-control datepicker" name="name"
												id="name" placeholder="Nhập tên cháu" value="" required="required">
									</div>
								</div>
								<div class="form-group row">
			            <label class="control-label col-sm-3">Giới tính<span class="text-danger">*</span></label>
			            <div class="col-sm-3">
			              <input  required="required" type="radio" name="sex" id ="nam" value="1"> Nam
			              <input type="radio"   name="sex" id ="nu"  value="0"> Nữ
			            </div>
			          </div>
								<div class="form-group row <?php echo e($errors->has('promotion_id') ? ' has-error' : ''); ?>">
									<label class="col-lg-3 control-label">Liên hệ gia đình </label>
									<div class="col-lg-3 ">
									<input type="text" class="form-control datepicker" name="family"
												id="family" placeholder="Nhập liên hệ" value="">
									</div>
								</div>
								<div class="form-group row <?php echo e($errors->has('promotion_id') ? ' has-error' : ''); ?>">
									<label class="col-lg-3 control-label">Điện thoại </label>
									<div class="col-lg-3 ">
									<input type="text" class="form-control datepicker" name="mobile"
												id="mobile" placeholder="Nhập điện thoại" value="">
									</div>
								</div>
								<div class="form-group row <?php echo e($errors->has('promotion_id') ? ' has-error' : ''); ?>">
									<label class="col-lg-3 control-label">Đia chỉ</label>
									<div class="col-lg-3 ">
									<input type="text" class="form-control datepicker" name="address"
												id="address" placeholder="Nhập địa chỉ" value="">
									</div>
								</div>
								<div class="form-group row">
										<label class="control-label col-sm-3">Chọn lớp học<span class="text-danger">*</span></label>
										<div class="col-sm-3">
											<select style="width: 100%;" class="select form-control"  required="required" name="class" id="class"
											 data-placeholder="Chọn lớp học">
												<option></option>
												<?php $__currentLoopData = $class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_contact_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($item_contact_list->id); ?>"><?php echo e($item_contact_list->name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
								</div>


								<div class="form-group row">
										<label class="control-label col-sm-3">Đăng ký phí học<span class="text-danger">*</span></label>
										<div class="col-sm-3">
											<select style="width: 100%;" multiple="multiple" class="select form-control"
											name="cost[]" id="cost"  required="required" data-placeholder="Chọn phí học">
												<option></option>
												<?php $__currentLoopData = $cost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($item_customer->id); ?>"><?php echo e($item_customer->name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											</select>
										</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-3 control-label">Trạng thái</label>
									<div class="col-lg-3 float-right">
										<select class="select form-control" data-placeholder="Chọn trạng thái" name="status" id="status">
					            			<option value="1">Đang học</option>
							            	<option value="0">Đã nghỉ</option>

						            	</select>
									</div>
								</div>
								<div class="text-right">
												<input type="hidden" name="button_action" id="button_action" value="insert" />
		          					<button type="submit" name="submit" class="btn btn-primary action">Lưu dữ liệu</button>
								</div>

							</div>
						</div>


						</div>

					</form>


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

					$("#from_date,#to_date").datepicker(
							{
								 todayHighlight:true,
								 clearBtn:true,
								 format:'dd-mm-yyyy',
								 todayBtn:true,
								 autoclose:true,
							}
					)

				});
			</script>

		</section>
		<!-- /.content -->


   	</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>