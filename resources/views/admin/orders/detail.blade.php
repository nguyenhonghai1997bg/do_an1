@extends('admin.layouts.master')

@section('title', __('orders.detail'))
@section('content')
<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

<section class="content-header ml-2">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ __('orders.detail') }}</h1>
        <div class="mt-3">
          <div><b>{{ __('orders.name') }}:</b> {{ $order->name }}</div>
          <div><b>{{ __('orders.email') }}:</b> {{ $order->email }}</div>
          <div><b>{{ __('orders.address') }}:</b> {{ $order->address }}</div>
          <div><b>{{ __('orders.phone') }}:</b> {{ $order->phone }}</div>
          <div><b>{{ __('orders.paymethod') }}:</b> {{ $order->paymethod->name }}</div>
          <div><b>{{ __('orders.total') }}:</b> {{ number_format($order->total) }} VND</div>
          <div><b>{{ __('orders.subtotal') }}: </b><span id="subtotal"></span></div>
          <div><b>{{ __('orders.totalShip') }}: </b><span id="totalShip"></span></div>
          <div><b>{{ __('orders.created_at') }}:</b> {{ $order->created_at }}</div>
           @if($order->deleted_at)
            <div><b>{{ __('orders.delted_by') }}:</b>
                @if($order->deleted_by)
                  {{ $order->delted_by }}
                @endif
            </div>
          @endif
          <div><b>{{ __('orders.status') }}:</b>
            @if($order->deleted_at)
              <span class="text-danger">{{ __('orders.deleted') }}</span>
            @else
              @if($order->status == \App\Order::WAITING)
                <span class="text-warning">{{ __('orders.waiting') }}</span>
              @endif
              @if($order->status == \App\Order::PROCESS)
                <span class="text-primary">{{ __('orders.process') }}</span>
              @endif
              @if($order->status == \App\Order::DONE)
                <span class="text-success">{{ __('orders.done') }}</span>
              @endif
            @endif
            @if($order->is_paymented == 1)
              <span class="ml-2 text-success">( {{ __('orders.paymented') }} )</span>
            @else
              <span class="ml-2 text-danger">( {{ __('orders.not_paymented') }} )</span>
            @endif
          </div>
          @if($order->deleted_at)
            <span>{{ Form::button(__('orders.deleted'), ['id' => 'danger', 'class' => 'btn btn-danger btn-sm mt-1', 'id' => 'perform1']) }}</span>
            @else
              @if($order->status > 0 && $order->status != 2)
                <span>{{ Form::button(__('orders.waiting'), ['id' => 'waiting', 'class' => 'btn btn-warning btn-sm mt-1', 'onclick' => "waiting($order->id)", 'id' => 'perform1']) }}</span>
              @endif
              @if($order->status < 1)
                <span>{{ Form::button(__('orders.process'), ['id' => 'process', 'class' => 'btn btn-warning btn-sm mt-1', 'onclick' => "process($order->id)", 'id' => 'perform1']) }}</span>
              @endif
              @if($order->status < 2)
                <span>{{ Form::button(__('orders.done'), ['id' => 'done', 'class' => 'btn btn-success btn-sm mt-1', 'onclick' => "done($order->id)", 'id' => 'perform2']) }}</span>
              @endif
            @endif
        </div>
      </div>
      
  </div><!-- /.container-fluid -->
</section>
<div class="row col-md-12">
  <div class="col-12">
  <div class="card">
    <div class="card-header">
    <h3 class="card-title">{{ __('orders.detail') }}</h3>
    <div class="card-tools">
      {{-- {{ Form::open(['method' => 'GET' ]) }}
        <div class="input-group input-group-sm" style="width: 150px;">
          <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ $key ?? '' }}">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </div>
      {{ Form::close() }} --}}
    </div>
    </div>
    <!-- /.card-header -->
    <?php $subtotal = 0; ?>
    <div class="card-body table-responsive p-0">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('detailOrders.name') }}</th>
          <th>{{ __('detailOrders.price') }}</th>
          <th>{{ __('detailOrders.quantity') }}</th>
          <th>{{ __('detailOrders.total') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($detailOrders) < 1)
          <tr>
            <td>{{ __('app.listEmpty') }}</td>
          </tr>
        @else
          @foreach($detailOrders as $key => $detail)
            <tr id="column-{{ $detail->id }}">
              <td>{{ app('request')->input('page') ? \App\DetailOrder::PERPAGE * (app('request')->input('page') - 1) + ($key + 1) :  $key + 1 }}</td>
              <td id="name-{{ $detail->product->id }}">{{ $detail->product->name }}</td>
              <td>{{ number_format($detail->price) }}</td>
              <td>{{ $detail->quantity }}</td>
              <td>{{ number_format($detail->quantity * $detail->price) }}</td>
              <?php $subtotal += $detail->quantity * $detail->price; ?>
            </tr>
          @endforeach
          <script>
            $('#subtotal').text('{{ number_format($subtotal) }} VND')
            $('#totalShip').text('{{ number_format($order->total - $subtotal)}} VND')
          </script>
        @endif
      </tbody>
    </table>
    <div class="mt-4">
      {{ $detailOrders->links() }}
    </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>

  <!-- Button trigger modal -->
<!-- Modal -->
<script type="text/javascript" src="{{ asset('custom/admin-detailorder.js') }}"></script>

<style type="text/css">
  #edit-icon:hover{
    cursor: pointer;
  }
</style>
@endsection
