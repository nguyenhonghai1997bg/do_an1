@extends('admin.layouts.master')

@section('title', __('orders.listDone'))
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

<section class="content-header ml-2">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
          <li class="breadcrumb-item active">{{ __('orders.listDone') }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">{{ __('orders.listDone') }}</h3>
    <div class="card-tools">
      {{ Form::open(['method' => 'GET' ]) }}
        <div class="input-group input-group-sm" style="width: 150px;">
          <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $key ?? '' }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </div>
      {{ Form::close() }}
    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <a href="{{ url('admin/manager/downloadExcel/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
    <a href="{{ url('admin/manager/downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>
    <a href="{{ url('admin/manager/downloadExcel/csv') }}"><button class="btn btn-success">Download CSV</button></a>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('orders.name') }}</th>
          <th>{{ __('orders.price') }}</th>
          <th>{{ __('orders.updated_at') }}</th>
          <th>{{ __('orders.detail') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($orders) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($orders as $key => $order)
            <tr id="column-{{ $order->id }}">
              <td>{{ app('request')->input('page') ? \App\Order::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td id="name-{{ $order->user_id ? $order->user->id : '' }}">{{ $order->name }}</td>
              <td>{{ number_format($order->total) }} VND</td>
              <td>{{ $order->updated_at }}</td>
              <th><a href="{{ route('admin.orders.show', ['id' => $order->id]) }}">{{ __('orders.detail') }}</a></th>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $orders->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>

  <!-- Button trigger modal -->
<!-- Modal -->
<script type="text/javascript" src="{{ asset('custom/admin-order.js') }}"></script>

<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
</style>
@endsection
