<!DOCTYPE html>
<html>
<head>
  <title>Đặt hàng thành công</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div>Bạn đã đặt hàng thành công, dưới đây là chi tiết đơn hàng của bạn:</div>
	<?php $detailOrders = $order->detailOrders; ?>
	<div class="container" style="margin-bottom: 30px;">
  <div><b>{{ __('orders.name') }}:</b> {{ $order->name }}</div>
  <div><b>{{ __('orders.email') }}:</b> {{ $order->email }}</div>
  <div><b>{{ __('orders.address') }}:</b> {{ $order->address }}</div>
  <div><b>{{ __('orders.phone') }}:</b> {{ $order->phone }}</div>
  <div><b>{{ __('orders.paymethod') }}:</b> {{ $order->paymethod->name }}</div>
  <div><b>{{ __('orders.total') }}:</b> {{ number_format($order->total) }} VND</div>
  <div><b>{{ __('orders.created_at') }}:</b> {{ $order->created_at }}</div>
  <div><b>{{ __('orders.status') }}:</b>
    @if ($order->deleted_at)
      <span class="text-danger">{{ __('orders.deleted') }}</span>
    @elseif ($order->status == \App\Order::PROCESS)
      <span class="text-primary">{{ __('orders.process') }}</span>
    @elseif ($order->status == \App\Order::DONE)
      <span class="text-success">{{ __('orders.done') }}</span>
    @elseif ($order->status == \App\Order::WAITING)
      <span class="text-waring">{{ __('orders.waiting') }}</span>
    @endif
    @if($paymented == 1)
      <span class="ml-2 text-success">( {{ __('orders.paymented') }} )</span>
    @else
      <span class="ml-2 text-danger">( {{ __('orders.not_paymented') }} )</span>
    @endif
  </div>

  </div>
    <!-- /.card-header -->
    <div class="container">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('detailOrders.name') }}</th>
          <th>{{ __('detailOrders.price') }}</th>
          <th>{{ __('detailOrders.quantity') }}</th>
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
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
    <!-- /.card-body -->
</div>

</body>
</html>