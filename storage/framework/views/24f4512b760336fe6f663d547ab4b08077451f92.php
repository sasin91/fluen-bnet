    <?php $__env->startSection('content'); ?>
        <div class="jumbotron">
        	<div class="container">
        		<h1>Hello, world!</h1>
        		<p>Contents...</p>
        		<p>
        			<a class="btn btn-primary btn-lg">Learn more</a>
        		</p>
        	</div>
        </div>
    <?php $__env->stopSection(); ?>    
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>