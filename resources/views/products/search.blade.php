@extends('layouts.master')

@section('title', 'Masha life | Products')
@section('content')

<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

<div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                <li><a href="#">{{ request('category_id') ? \App\Category::findOrFail(request('category_id'))->name . ' ' . \App\Category::findOrFail(request('category_id'))->catalog->name : 'all' }}</a></li>
            <li class="active">{{ __('app.products') }}</li>
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
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- aside widget -->
                    {{-- <div class="aside">
                        <h3 class="aside-title">Shop by:</h3>
                        <ul class="filter-list">
                            <li><span class="text-uppercase">color:</span></li>
                            <li><a href="#" style="color:#FFF; background-color:#8A2454;">Camelot</a></li>
                            <li><a href="#" style="color:#FFF; background-color:#475984;">East Bay</a></li>
                            <li><a href="#" style="color:#FFF; background-color:#BF6989;">Tapestry</a></li>
                            <li><a href="#" style="color:#FFF; background-color:#9A54D8;">Medium Purple</a></li>
                        </ul>

                        <ul class="filter-list">
                            <li><span class="text-uppercase">Size:</span></li>
                            <li><a href="#">X</a></li>
                            <li><a href="#">XL</a></li>
                        </ul>

                        <ul class="filter-list">
                            <li><span class="text-uppercase">Price:</span></li>
                            <li><a href="#">MIN: $20.00</a></li>
                            <li><a href="#">MAX: $120.00</a></li>
                        </ul>

                        <ul class="filter-list">
                            <li><span class="text-uppercase">Gender:</span></li>
                            <li><a href="#">Men</a></li>
                        </ul>

                        <button class="primary-btn">Clear All</button>
                    </div> --}}
                    <!-- /aside widget -->

                    <!-- aside widget -->
                    <div class="aside">
                    <h3 class="aside-title">{{ __('app.search') }}</h3>
                        <div id="price-slider"></div>
                        <input type="hidden" name="" id="value-lower">
                        <input type="hidden" name="" id="value-upper">
                    </div>
                    <div class="btn btn-success" onclick="search()">{{ __('app.search') }}</div>
                    <!-- aside widget -->

                {{--    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">Filter By Color:</h3>
                        <ul class="color-option">
                            <li><a href="#" style="background-color:#475984;"></a></li>
                            <li><a href="#" style="background-color:#8A2454;"></a></li>
                            <li class="active"><a href="#" style="background-color:#BF6989;"></a></li>
                            <li><a href="#" style="background-color:#9A54D8;"></a></li>
                            <li><a href="#" style="background-color:#675F52;"></a></li>
                            <li><a href="#" style="background-color:#050505;"></a></li>
                            <li><a href="#" style="background-color:#D5B47B;"></a></li>
                        </ul>
                    </div>
                    <!-- /aside widget -->
 --}}
                    <!-- aside widget -->
                {{--    <div class="aside">
                        <h3 class="aside-title">Filter By Size:</h3>
                        <ul class="size-option">
                            <li class="active"><a href="#">S</a></li>
                            <li class="active"><a href="#">XL</a></li>
                            <li><a href="#">SL</a></li>
                        </ul>
                    </div> --}}
                    <!-- /aside widget -->


                    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">{{ __('app.categories') }}</h3>
                        <ul class="list-links">
                            @foreach($categories2 as $category)
                                <?php $from = request('from', 1); ?>
                                <?php $to = request('to', $maxPrice); ?>
                                <?php $key = request('key', ''); ?>
                                <li class="active"><a href="{{ url("products/search-by-price?category_id=$category->id&key=$key&from=$from&to=$to") }}">{{ $category->name . ' ' . $category->catalog->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /aside widget -->

                    <!-- aside widget -->
                    <!-- /aside widget -->
                </div>
                <!-- /ASIDE -->

                <!-- MAIN -->
                <div id="main" class="col-md-9">
                    <div id="store">
                        @if (count($products) < 1)
                            <div class="alert alert-info">{{ __('app.listEmpty') }}</div>
                        @endif
                        <!-- row -->
                        <div id="product-slick-1" class="product-slick">
                            <!-- Product Single -->
                            @foreach($products as $product)
                                <?php $avg = ceil(\App\Review::where('product_id', $product->id)->avg('rating')); ?>
                                <div class="product product-single">
                                    <div class="product-thumb">
                                        <div class="product-label">
                                            @if($product->sale)
                                            <span class="sale">-{{ $product->sale->sale_price }}%</span>
                                            @endif
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
                            @endforeach
                            {{ !is_array($products) ? $products->links() : '' }}
                            <!-- /Product Single -->

                            <!-- Product Single -->
                            <!-- /Product Single -->

                            <!-- Product Single -->
                            <!-- /Product Single -->
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /STORE -->

                    <!-- store bottom filter -->
                <!-- /MAIN -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <script src="{{ asset('users/js/nouislider.min.js') }}"></script>
    <script type="text/javascript">


    var getParams = function (url) {
        var params = {};
        var parser = document.createElement('a');
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }

        return params;
    };

    function searchByCategory(id) {
        window.location.href = window.location.href + '?category_id=' + id;
        console.log(getParams(window.location.href).category_id)
    }

    var slider = document.getElementById('price-slider');
      if (slider) {
        noUiSlider.create(slider, {
          start: [{{ request('from', 1) }}, {{ request('to', $maxPrice) }}],
          connect: true,
          tooltips: [true, true],
          format: {
            to: function(value) {
              return value.toFixed(0);
            },
            from: function(value) {
              return value
            }
          },
          range: {
            'min': 1,
            'max': {{ $maxPrice }}
          }
        });
      }
      var skipValues = [
        document.getElementById('value-lower'),
        document.getElementById('value-upper')
    ];
    slider.noUiSlider.on('update', function(values, handle) {
        skipValues[handle].value = values[handle];
    });

    function search() {
        var key = $('#input-search').val() || '';
        var from = $('#value-lower').val();
        var to = $('#value-upper').val();
        var category_id = getParams(window.location.href).category_id || '';
        window.location.href = window.location.origin + `/products/search-by-price?key=${key}&from=${from}&to=${to}&category_id=${category_id}`;
    }

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
                  <img src="${data.options.image_url}" alt="">
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
