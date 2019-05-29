@extends('admin.layouts.master')

@section('title', __('users.profile'))
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('users.profile') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row ml-3">
  <div class="col-12">
    <div class="col-md-10">
      @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      @if(count($errors->all()))
          @foreach($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
          @endforeach
      @endif
      @if(session('warning'))
          <div class="alert alert-warning">{{ session('warning') }}</div>
      @endif
          {{ Form::open(['route' => 'admin.update_profile', 'id' => 'checkout-form', 'class' => 'clearfix']) }}
          <div class="col-md-6">
          <div class="billing-details">
              <div class="section-title">
              <h3 class="title">{{ __('users.profile') }}</h3>
              </div>
              <div class="form-group">
              <input class="form-control" type="text" name="name" placeholder="{{ __('users.name') }}" value="{{ Auth::user() ? Auth::user()->name : '' }}">
              </div>
              <div class="form-group">
              <input class="form-control" type="email" disabled placeholder="{{ __('users.email') }}" value="{{ Auth::user() ? Auth::user()->email : '' }}">
              </div>
              <div class="form-group">
              <input class="form-control" type="date" name="birth_day" id="address-order" placeholder="{{ __('users.birth_day') }}" value="{{ (Auth::user() && Auth::user()->birth_day) ? Auth::user()->birth_day : '' }}">
              </div>
              <div class="form-group">
              <input class="form-control" type="text" name="address" id="address-order" placeholder="{{ __('users.address') }}" value="{{ Auth::user() ? Auth::user()->address : '' }}">
              </div>
              <div class="form-group">
              <input class="form-control" type="number" name="phone" placeholder="{{ __('users.phone') }}" value="{{ Auth::user() ? Auth::user()->phone ?? '' : '' }}">
              </div>
              <div class="form-group">
              <input class="form-control" type="password" name="password" placeholder="{{ __('users.password') }}" value="">
              </div>
              <div class="form-group">
              <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('users.password_confirmation') }}" value="">
              </div>
              <input type="submit" class="btn btn-success" value="{{ __('app.edit') }}">
          </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@endsection
