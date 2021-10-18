

<?php $__env->startSection('title'); ?>
  work_xml
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<h1>Website for translating xml files</h1>

<form action="<?php echo e(route('file_analyzes')); ?>" method="post">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <button type="submit" name="button" class="GO">GO</button>
  </div>
</form>

<form action="<?php echo e(route('file_output')); ?>" method="post">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <button type="submit" name="button2" class="OUT">OUT2</button>
  </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\work\resources\views/input.blade.php ENDPATH**/ ?>