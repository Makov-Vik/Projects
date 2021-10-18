

<?php $__env->startSection('title'); ?>
  About
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <h1>About</h1>
<?php $__env->stopSection(); ?>

<form action="/about/input" method="post">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <label for="name">Input file</label>
    <input type="text" name="file" id="file" class="form-control">
  </div> 
  <button type="submit" name="button">Go</button>
</form>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\work\resources\views/about.blade.php ENDPATH**/ ?>