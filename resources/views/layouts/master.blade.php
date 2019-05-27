<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>@yield('title')</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('users/css/bootstrap.min.css') }}" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{  asset('users/css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{  asset('users/css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{  asset('users/css/nouislider.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{  asset('users/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{  asset('users/css/style.css') }}" />
    <script src="{{ asset('users/js/jquery.min.js') }}"></script>
    <script src="{{ asset('users/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">
</head>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

<body>
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')
    <script src="{{ asset('users/js/slick.min.js') }}"></script>
    <script src="{{ asset('users/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('users/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('users/js/main.js') }}"></script>

</body>
</html>