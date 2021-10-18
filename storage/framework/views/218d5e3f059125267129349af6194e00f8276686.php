

<?php $__env->startSection('title'); ?>
  work_xml
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<h1>Website for translating xml files</h1>

<form action="<?php echo e(route('file_analyzes')); ?>" method="post">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <label for="name">Input file</label>
    <button type="submit" name="button" class="GO">Go</button>
  </div>
    <textarea name="file" id="file"></textarea>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\work\resources\views/translate.blade.php ENDPATH**/ ?>