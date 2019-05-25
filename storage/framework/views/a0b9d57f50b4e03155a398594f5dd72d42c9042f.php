<?php $__env->startSection('content'); ?>
<html lang="en">
<head>
        <!-- <script src="//code.jquery.com/jquery.js"></script> -->
            <script src="<?php echo e(asset('public/js/jquery-3.2.1.js')); ?>"></script>
</head>
	<body>
		<section class="content">
		    <div class="row">
		      <div class="col-md-12">
		        <ol class="breadcrumb">
		         <!-- <li class="breadcrumb-item">Home</li> -->
		         <li class="breadcrumb-item"><a href="/hoahong"><i class="fa far fa-arrow-circle-left"></i>Trang chủ</a></li>
		       </ol>
          </div>
           <div class="col-md-12">
              		<?php echo Create_Session(); ?>


                  <!-- Emp Max -->
    						<div class="col-lg-3">
    							<div class="panel panel-flat">
    								<div class="box-header with-border">
    					              <h3 class="box-title"></h3>
    					        </div>
    					         	<div class="table-responsive">
    									<table class="table text-nowrap">
    										<thead>
    											<tr>

    											</tr>
    										</thead>
    										<tbody>

    											<tr>
    												<td>
    													<div class="media-body">
    														<div class="media-heading">

    														</div>
    														<div class="text-muted text-size-small"></div>
    													</div>
    												</td>
    												<td>
    													<h6 class="text-semibold no-margin"></h6>
    												</td>

    											</tr>

    										</tbody>
    									</table>
    								 </div>
    							 </div>
    						</div>
    						<!--End Emp Max -->
            </div>
		  </div>
		  <!-- /.row -->
		</section>

   	</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>