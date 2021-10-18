<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title'); ?></title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="container">
    <div class="row">
      <div class="col-8">
        <?php echo $__env->yieldContent('content'); ?>  
      </div>
      <div class="col-4">
        <?php echo $__env->make('includes.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
    </div>
  </div>

</body>
</html>
<?php /**PATH C:\OpenServer\domains\work\resources\views/layouts/app.blade.php ENDPATH**/ ?>