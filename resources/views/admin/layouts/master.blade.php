<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
</head>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>
<body class="hold-transition sidebar-mini">
  <script type="text/javascript">
    var pusher = new Pusher('a70261703ef25d858f99', {
      encrypted: true,
      cluster: 'ap1',
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('order-channel');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\OrderEvent', function(data) {
        $('#list-notifies').prepend(`
            <div class="dropdown-divider"></div>
            <a href="${data.link}" class="dropdown-item" onclick="seen(${data.notify_id})">
              <i class="mr-2"></i> <span id="message" onclick="seen(${data.notify_id})">${data.notify}</span>
            </a>
          `)

        var countNotify = parseInt($('#count-notifies').text());
        $('#count-notifies').text(countNotify + 1)
        $('#count-notifies2').text(countNotify + 1)
        alertify.success(data.notify)

        Push.create(data.notify, {
          body: data.notify,
          icon: "{{ asset('images/logo.jpg') }}",
          timeout: 5000,
          onClick: function() {
            window.focus();
            window.location.href = data.link
          }
      });
    });
    function seen(id) {
      $.ajax({
        url: window.location.origin + '/admin/manager/notifies/seen/' + id,
        method: 'POST'
      })
    }
  </script>
  <!-- /.navbar -->
  @include('admin.layouts.navbar')
  <!-- Main Sidebar Container -->
  @include('admin.layouts.slidebar')

  <!-- Main -->
<div class="content-wrapper">
  @yield('content')
</div>

  <!-- Control Sidebar -->
  {{-- <aside class="control-sidebar control-sidebar-dark">
    Control sidebar content goes here
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside> --}}
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  {{-- @include('admin.layouts.footer') --}}
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
