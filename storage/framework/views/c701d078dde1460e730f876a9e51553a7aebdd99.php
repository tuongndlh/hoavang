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
		         <li class="breadcrumb-item"><a href="/linkhouse"><i class="fa far fa-arrow-circle-left"></i></a></li>
		       </ol>
          </div>
           <div class="col-md-12">
              		<?php echo Create_Session(); ?>

              <h1 > Chưa có dữ liệu</h1>
            </div>
		  </div>
		  <!-- /.row -->
		</section>

   	</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>