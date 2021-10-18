

<?php $__env->startSection('title'); ?>
  xml
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <?php $__currentLoopData = $date; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class='alert alert-info' id="output">
      <h6><?php echo e($el->smth); ?></h6>
    </div>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\work\resources\views/messege.blade.php ENDPATH**/ ?>