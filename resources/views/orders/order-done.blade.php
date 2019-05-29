@extends('layouts.master')

@section('title', 'Masha life | Đơn hàng đã thực hiện xong')
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

@include('layouts.nav-child')

<div id="breadcrumb">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
      <li class="active">{{ __('carts.orderDone') }}</li>
    </ul>
  </div>
</div>
<!-- /BREADCRUMB -->

<!-- section -->
<div class="section">
  <!-- container -->
  <div class="container">
    <!-- row -->
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <a href="{{ route('home') }}" class="btn btn-success">{{ __('app.home') }}</a>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<script type="text/javascript" src="{{ asset('custom/checkout.js') }}"></script>
@endsection
