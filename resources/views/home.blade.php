@extends('layouts.master')

@section('title', 'Masha life')
@section('content')
@include('layouts.nav')
<div id="home">
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.3&appId=1099092086864831&autoLogAppEvents=1"></script>
    <script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

        <!-- container -->
        <div class="container">
            <!-- home wrap -->
            <div class="home-wrap">
                <!-- home slick -->
                <div id="home-slick">
                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src=" {{ asset('users/img/banner01.jpg') }}" alt="">
                        <div class="banner-caption text-center">
                            <h1>Bags sale</h1>
                            <h3 class="white-color font-weak">Up to 50% Discount</h3>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src=" {{ asset('users/img/banner02.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="primary-color">HOT DEAL<br><span class="white-color font-weak">Up to 50% OFF</span></h1>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src=" {{ asset('users/img/banner03.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="white-color">New Product <span>Collection</span></h1>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                    <!-- /banner -->
                </div>
                <!-- /home slick -->
            </div>
            <!-- /home wrap -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOME -->

    <!-- section -->
    <!-- /section -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section-title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h4 class="title">{{ __('products.topSale') }}</h4>
                        <div class="pull-right">
                            <div class="product-slick-dots-1 custom-dots"></div>
                        </div>
                    </div>
                </div>
                <!-- /section-title -->

                <!-- banner -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="banner banner-2">
                        <img src=" {{ asset('users/img/banner14.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h2 class="white-color">{{ __('products.saleList') }}</h2>
                            <a href="{{ route('products.sale') }}" class="primary-btn">{{ __('app.shopNow') }}</a>
                        </div>
                    </div>
                </div>
                <!-- /banner -->

                <!-- Product Slick -->
                <div class="col-md-9 col-sm-6 col-xs-6">
                    <div class="row">
                        <div id="product-slick-1" class="product-slick">
                            <!-- Product Single -->
                            @foreach($topSale as $product)
                                <?php $avg = ceil(\App\Review::where('product_id', $product->id)->avg('rating')); ?>
                                <div class="product product-single">
                                    <div class="product-thumb">
                                        <div class="product-label">
                                            <span class="sale">-{{ $product->sale->sale_price }}%</span>
                                        </div>
                                       {{--  <ul class="product-countdown">
                                            <li><span>00 H</span></li>
                                            <li><span>00 M</span></li>
                                            <li><span>00 S</span></li>
                                        </ul> --}}
                                        <button class="main-btn quick-view"><i class="fa fa-search-plus"></i><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ __('app.quickView') }}</a></button>
                                        <img src=" {{ asset('images/products/' . $product->images->first()->image_url) }}" alt="">
                                    </div>
                                    <div class="product-body">
                                        @if($product->sale)
                                            <h4 class="product-price">{{ number_format(floor($product->price - (($product->price * $product->sale->sale_price)/100))) }} vnd <del class="product-old-price">{{ number_format($product->price) }} vnd</del></h4>
                                        @else
                                            <h4 class="product-price">{{ number_format($product->price) }} vnd</h4>
                                        @endif
                                        <div class="product-rating">
                                            @for($i = 1; $i <= $avg; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                        </div>
                                        <h2 class="product-name"><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a></h2>
                                        <div class="product-btns" style="text-align: center;">
                                            @if($product->warehouse->quantity > 0)
                                                <button class="primary-btn add-to-cart btn-sm" id="add-cart" onclick="addCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale ? floor($product->price - (($product->price * $product->sale->sale_price)/100)) : $product->price }}, '{{ $product->images->first()->image_url }}')">
                                                <i class="fa fa-shopping-cart"></i> {{ __('app.addToCart') }}
                                            </button>
                                            @else
                                                <button class="primary-btn add-to-cart btn-sm hethang" style="background: #999999;" >
                                                <i class="fa fa-shopping-cart"></i> {{ __('app.hethang') }}
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- /Product Single -->

                            <!-- Product Single -->
                            <!-- /Product Single -->

                            <!-- Product Single -->
                            <!-- /Product Single -->
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                        <a href="{{ route('allTopSale') }}" class="btn btn-default">{{ __('app.viewAll') }}</a>
                    </div>
                </div>
                <!-- /Product Slick -->
            </div>
            <!-- /row -->

            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h4 class="title">{{ __('products.topView') }}</h4>
                    </div>
                </div>
                <!-- section title -->
                <!-- Product Single -->
                @foreach($topViewtProducts as $product)
                    <?php $avg = ceil(\App\Review::where('product_id', $product->id)->avg('rating')); ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="product product-single">
                            <div class="product-thumb">
                                <button class="main-btn quick-view"><i class="fa fa-search-plus"></i><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ __('app.quickView') }}</a></button>
                                <img src=" {{ asset('images/products/' . $product->images->first()->image_url) }}" alt="">
                            </div>
                            <div class="product-body">
                                @if($product->sale)
                                    <h3 class="product-price">{{ number_format(floor($product->price - (($product->price * $product->sale->sale_price)/100))) }} vnd <del class="product-old-price">{{ number_format($product->price) }} vnd</del></h3>
                                @else
                                    <h3 class="product-price">{{ number_format($product->price) }} vnd</h3>
                                @endif
                                <div class="product-rating">
                                    @for($i = 1; $i <= $avg; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </div>
                                <h2 class="product-name"><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a></h2>
                                <div class="product-btns" style="text-align: center;">
                                    @if($product->warehouse->quantity > 0)
                                            <button class="primary-btn add-to-cart btn-sm" id="add-cart" onclick="addCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale ? floor($product->price - (($product->price * $product->sale->sale_price)/100)) : $product->price }}, '{{ $product->images->first()->image_url }}')">
                                            <i class="fa fa-shopping-cart"></i> {{ __('app.addToCart') }}
                                        </button>
                                    @else
                                            <button class="primary-btn add-to-cart btn-sm hethang" style="background: #999999;" >
                                            <i class="fa fa-shopping-cart"></i> {{ __('app.hethang') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- /Product Single -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h4 class="title">{{ __('products.latestProduct') }}</h4>
                    </div>
                </div>
                <!-- section title -->
                <!-- Product Single -->
                @foreach($latestProducts as $product)
                    <?php $avg = ceil(\App\Review::where('product_id', $product->id)->avg('rating')); ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="product product-single">
                            <div class="product-thumb">
                                <button class="main-btn quick-view"><i class="fa fa-search-plus"></i><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ __('app.quickView') }}</a></button>
                                <img src=" {{ asset('images/products/' . $product->images->first()->image_url) }}" alt="">
                            </div>
                            <div class="product-body">
                                @if($product->sale)
                                    <h3 class="product-price">{{ number_format(floor($product->price - (($product->price * $product->sale->sale_price)/100))) }} vnd <del class="product-old-price">{{ number_format($product->price) }} vnd</del></h3>
                                @else
                                    <h3 class="product-price">{{ number_format($product->price) }} vnd</h3>
                                @endif
                                <div class="product-rating">
                                    @for($i = 1; $i <= $avg; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </div>
                                <h2 class="product-name"><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a></h2>
                                <div class="product-btns" style="text-align: center;">
                                    @if($product->warehouse->quantity > 0)
                                            <button class="primary-btn add-to-cart btn-sm" id="add-cart" onclick="addCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale ? floor($product->price - (($product->price * $product->sale->sale_price)/100)) : $product->price }}, '{{ $product->images->first()->image_url }}')">
                                            <i class="fa fa-shopping-cart"></i> {{ __('app.addToCart') }}
                                        </button>
                                    @else
                                        <button class="primary-btn add-to-cart btn-sm hethang" style="background: #999999;" >
                                            <i class="fa fa-shopping-cart"></i> {{ __('app.hethang') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- /Product Single -->
            </div>
            <!-- /row -->

            <!-- row -->
            <!-- /row -->

            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h4 class="title">{{ __('products.topOrders') }}</h4>
                    </div>
                </div>
                <!-- section title -->

                <!-- Product Single -->
                @foreach($topOrders as $product)
                    <?php $avg = ceil(\App\Review::where('product_id', $product->id)->avg('rating')); ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="product product-single">
                            <div class="product-thumb">
                                <button class="main-btn quick-view"><i class="fa fa-search-plus"></i><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ __('app.quickView') }}</a></button>
                                <img src=" {{ asset('images/products/' . $product->images->first()->image_url) }}" alt="">
                            </div>
                            <div class="product-body">
                                @if($product->sale)
                                    <h3 class="product-price">{{ number_format(floor($product->price - (($product->price * $product->sale->sale_price)/100))) }} vnd <del class="product-old-price">{{ number_format($product->price) }} vnd</del></h3>
                                @else
                                    <h3 class="product-price">{{ number_format($product->price) }} vnd</h3>
                                @endif
                                <div class="product-rating">
                                    @for($i = 1; $i <= $avg; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </div>
                                <h2 class="product-name"><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a></h2>
                                <div class="product-btns" style="text-align: center;">
                                    @if($product->warehouse->quantity > 0)
                                        <button class="primary-btn add-to-cart btn-sm" id="add-cart" onclick="addCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale ? floor($product->price - (($product->price * $product->sale->sale_price)/100)) : $product->price }}, '{{ $product->images->first()->image_url }}')">
                                            <i class="fa fa-shopping-cart"></i> {{ __('app.addToCart') }}
                                        </button>
                                    @else
                                        <button class="primary-btn add-to-cart btn-sm hethang" style="background: #999999;">
                                            <i class="fa fa-shopping-cart"></i> {{ __('app.hethang') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- /Product Single -->

                <!-- Product Single -->
                <!-- /Product Single -->
            </div>
            <!-- /row -->
            <div class="col-md-12">
                <div class="col-md-11"></div>
                <div class="col-md-1">
                    <a href="{{ route('allTopOrder') }}" class="btn btn-default">{{ __('app.viewAll') }}</a>
                </div>
            </div>
        </div>
        <!-- /container -->
    </div>
<script type="text/javascript">

    $('.hethang').click(function () {
        alertify.warning('{{ __('app.hethangroi') }}')
    })

    function addCart(product_id, name, price, image_url) {
      $.ajax({
        url: window.location.origin + '/carts/',
        method: 'POST',
        data: {
          product_id: product_id,
          name: name,
          price: price,
          quantity: 1,
          image_url: image_url
        },
        success: function(data) {
          $('#cart-' + data.rowId).hide();
          var html = `<div class="product product-widget" id="cart-${data.rowId}">
              <div class="product-thumb">
                  <img src="{{ asset('images/products/')}}/${data.options.image_url}" alt="">
              </div>
              <div class="product-body">
                  <h3 class="product-price">${data.price} <span class="qty">x${data.qty}</span></h3>
                  <h2 class="product-name"><a href="product-page.html">${data.name}</a></h2>
              </div>
              <button class="cancel-btn" onclick="deleteCart(${data.id}, '${data.rowId}')"><i class="fa fa-trash"></i></button>
            </div>`;
          $('#shopping-cart-list').prepend(html)
          $('#quantity').val(0)
          $('#qty').text(data.count)
          $('#subtotal').text(data.subtotal);
          alertify.success('Thêm vào giỏ hàng thành công')
        },
        error: function(errors) {
          if(errors.status == 422) {
            if (errors.responseJSON.errors.product_id) {
              alertify.error(errors.responseJSON.errors.product_id[0]);
            }
            if (errors.responseJSON.errors.name) {
              alertify.error(errors.responseJSON.errors.name[0]);
            }
            if (errors.responseJSON.errors.quantity) {
              alertify.error(errors.responseJSON.errors.quantity[0]);
            }
            if (errors.responseJSON.errors.price) {
              alertify.error(errors.responseJSON.errors.price[0]);
            }
            if (errors.responseJSON.errors.image_url) {
              alertify.error(errors.responseJSON.errors.image_url[0]);
            }
          }
        }
      })
    }
</script>
@endsection
