<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="animate fadeIn">
	   		<?php echo Create_Session(); ?>

	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>