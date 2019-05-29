@extends('layouts.master')

@section('title', 'Masha life | Hóa đơn đã xóa')
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

@include('layouts.nav-child')

<div id="breadcrumb">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li class="active">Orders</li>
    </ul>
  </div>
</div>
<!-- /BREADCRUMB -->

<!-- section -->
<div class="section">
  <!-- container -->
  <div class="container">
    <!-- row -->
    <div class="row">
      @if(count($errors->all()))
        @foreach($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
      @endif
        <div class="col-md-12">
          <div class="order-summary clearfix">
            <div class="section-title">
              <h3 class="title">{{ __('carts.orderDetail') }}</h3>
            </div>
            <a href="{{ route('users.show.list-order') }}" class="btn btn-success">{{ __('orders.listOrders') }}</a>
            <table class="shopping-cart-table table">
             <thead>
              <tr>
                <th>#</th>
                <th>{{ __('orders.id') }}</th>
                <th>{{ __('orders.name') }}</th>
                 <th>{{ __('orders.address') }}</th>
                <th>{{ __('orders.price') }}</th>
                <th>{{ __('orders.detail') }}</th>
                <th>{{ __('orders.created_at') }}</th>
                <th>{{ __('orders.deleted_at') }}</th>
                <th>{{ __('orders.deleted_by') }}</th>
                <th width="10%">{{ __('orders.status') }}</th>
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
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ number_format($order->total) }} VND</td>
                    <th><a href="{{ route('users.orders.detail', ['id' => $order->id]) }}">{{ __('orders.detail') }}</a></th>
                    <th>{{ !empty($order->created_at) ? $order->created_at : '' }}</th>
                    <th>{{ !empty($order->deleted_at) ? $order->deleted_at : '' }}</th>
                    <th>{{ !empty($order->deleted_by) ? $order->deleted_by : '' }}</th>
                    <td>
                      <div class="form-group">
                        <div class="row" id="status-{{ $order->id }}">
                          @if ($order->deleted_at)
                            {{ __('orders.deleted') }}
                          @elseif ($order->status == \App\Order::PROCESS)
                            {{ __('orders.process') }}
                          @elseif ($order->status == \App\Order::DONE)
                            {{ __('orders.done') }}
                          @elseif ($order->status == \App\Order::WAITING)
                            {{ __('orders.waiting') }}
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
          {{ $orders->links() }}
        </div>
      </div>
    <!-- /row -->
    </div>
  <!-- /container -->
</div>
@endsection
