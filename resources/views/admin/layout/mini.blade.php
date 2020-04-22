<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{__('admin.system_name')}} | @section('title') {{$system['title']}} @show</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <link rel="stylesheet" href="{{mix('css/admin.css')}}">
  @stack('styles')
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition @yield('body-style')">
  @yield('content')
  <script src="{{mix('js/admin.js')}}"></script>
  <script>
    var setting = {
      toastr: {
        type: "{{session('toastr')}}",
        message: "{{session('message')}}",
      }
    }
  </script>
  @stack('scripts')
</body>

</html>