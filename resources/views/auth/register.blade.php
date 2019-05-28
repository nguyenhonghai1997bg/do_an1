<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Masha Life | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="register-box">
  <div class="register-logo">
    <a href="{{ route('home') }}"><b>Masha</b>Life</a>
  </div>
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">{{ __('app.register') }}</p>
      {{-- @if(count($errors->all()) > 0)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
      @endif --}}
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group has-feedback">
        <input type="text" class="form-control" name="name" placeholder="{{ __('users.name') }}">
          @if ($errors->has('name'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="email" placeholder="{{ __('users.email') }}">
          @if ($errors->has('email'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" placeholder="{{ __('users.password') }}">
          @if ($errors->has('password'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('users.password_confirmation') }}">
          @if ($errors->has('password_confirmation'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback">
        <input type="date" class="form-control" name="birth_day" placeholder="{{ __('users.birth_day') }}">
          @if ($errors->has('birth_day'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('birth_day') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="address" placeholder="{{ __('users.address') }}">
          @if ($errors->has('address'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('address') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="phone" placeholder="Phone">
          @if ($errors->has('phone'))
            <span class="text-danger" role="alert">
              <strong>{{ $errors->first('phone') }}</strong>
            </span>
          @endif
        </div>
        

        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('app.register') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="{{ route('login') }}" class="text-center">{{ __('app.login') }}</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>
</body>
</html>
