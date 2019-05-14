@extends('layouts.master')

@section('content')

<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

@include('layouts.nav-child')

<div id="breadcrumb">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li class="active">Checkout</li>
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
      @if(session('warning'))
          <div class="alert alert-warning">{{ session('warning') }}</div>
      @endif
        {{ Form::open(['route' => 'orders.store', 'id' => 'checkout-form', 'class' => 'clearfix']) }}
        <div class="col-md-6">
          <div class="billing-details">
            <p>Already a customer ? <a href="#">Login</a></p>
            <div class="section-title">
              <h3 class="title">Billing Details</h3>
            </div>
            <div class="form-group">
            </div>
            <div class="form-group">
              <input class="input" type="text" name="name" placeholder="Name" value="{{ Auth::user() ? Auth::user()->name : '' }}">
            </div>
            <div class="form-group">
              <input class="input" type="email" name="email" placeholder="Email" value="{{ Auth::user() ? Auth::user()->email : '' }}">
            </div>
            <div class="form-group">
              <input class="input" type="text" name="address" placeholder="Address" value="{{ Auth::user() ? Auth::user()->address : '' }}">
            </div>
            <div class="form-group">
              <input class="input" type="tel" name="phone" placeholder="Telephone" value="{{ Auth::user() ? Auth::user()->phone ?? '' : '' }}">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="payments-methods">
            <div class="section-title">
              <h4 class="title">Payments Methods</h4>
            </div>
            @foreach(\App\Paymethod::all(['id', 'name']) as $paymethod)
            <div class="input-checkbox">
              {!! Form::radio('paymethod_id', $paymethod->id, false, ['id' => 'payments' . $paymethod->id]) !!}
              <label for="payments{{ $paymethod->id }}" >{{ $paymethod->name }}</label>
            </div>
            @endforeach
          </div>
        </div>

        <div class="col-md-12">
          <div class="order-summary clearfix">
            <div class="section-title">
              <h3 class="title">{{ __('carts.orderDetail') }}</h3>
            </div>
            <table class="shopping-cart-table table">
              <thead>
                <tr>
                  <th>{{ __('carts.product') }}</th>
                  <th></th>
                  <th class="text-center">{{ __('carts.price') }}</th>
                  <th class="text-center">{{ __('carts.quantity') }}</th>
                  <th class="text-center">{{ __('carts.total') }}</th>
                  <th class="text-right"></th>
                </tr>
              </thead>
              <tbody>
                @if(\Cart::content())
                  @foreach(\Cart::content() as $cart)
                  <tr id="row-{{ $cart->rowId }}">
                    <td class="thumb"><img src="{{ $cart->options->image_url }}" alt=""></td>
                    <td class="details">
                      <a href="{{ route('frontend.products.show', ['id' => $cart->id, 'slug' => \Str::slug($cart->name, '-')]) }}">{{ $cart->name }}</a>
                    </td>
                    <td class="price text-center"><strong>{{ number_format($cart->price) }} VND</strong></td>
                    <td class="qty text-center">
                      <input class="input" type="number" value="{{ $cart->qty }}" id="qty-{{ $cart->rowId }}" onchange="updateCart('{{ $cart->rowId }}')">
                    </td>
                    <td class="total text-center"><strong class="primary-color" id="price-row-{{ $cart->rowId }}">{{ number_format($cart->price * $cart->qty) }}</strong></td>
                    <td class="text-right">
                      <a href="#" class="main-btn icon-btn" onclick="deleteCart({{ $cart->id }}, '{{ $cart->rowId }}', '{{ __('app.confirm') }}', '{{ __('cart.confirm') }}')"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th class="empty" colspan="3"></th>
                  <th>TOTAL</th>
                  <th colspan="2" class="total" id="total">{{ number_format(\Cart::subtotal(0,'.','')) }}</th>
                </tr>
              </tfoot>
            </table>
            <div class="pull-right">
              <button class="primary-btn">{{ __('orders.order') }}</button>
            </div>
          </div>

        </div>
      {{ Form::close() }}
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<script type="text/javascript" src="{{ asset('custom/checkout.js') }}"></script>
@endsection
