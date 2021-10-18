<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  @include('includes.header')
  <div class="container">
    <div class="row">
      <div class="col-8">
        @yield('content')  
      </div>
      <div class="col-4">
        @include('includes.aside')
      </div>
    </div>
  </div>

</body>
</html>
