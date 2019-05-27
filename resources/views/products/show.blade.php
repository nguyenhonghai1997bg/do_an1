@extends('layouts.master')

@section('title', 'Masha life | ' . $product->name)
@section('content')

<script src="{{ asset('plugins/alertifyjs/alertify.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/alertifyjs/css/alertify.min.css') }}">

@include('layouts.nav-child')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.3&appId=1099092086864831&autoLogAppEvents=1"></script>

<div id="breadcrumb">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="#">{{ __('app.home') }}</a></li>
      <li><a href="#">{{ __('app.products') }}</a></li>
      <li class="active">{{ $product->name }}</li>
    </ul>
  </div>
</div>
<div class="section">
  <!-- container -->
  <div class="container">
    <!-- row -->
    <div class="row">
      <!--  Product Details -->
      <div class="product product-details clearfix">
        <div class="col-md-6">
          <div id="product-main-view">
            @foreach($product->images as $key => $image)
            <div class="product-view" >
              <img src="{{ asset('images/products/' . $image->image_url) }}" alt="" height="100%" id="image-{{ $key }}">
            </div>
            @endforeach
          </div>
          <div id="product-view">
            @foreach($product->images as $image)
              <div class="product-view" >
                <img src="{{ asset('images/products/' . $image->image_url) }}" alt="" width="100%" height="100%">
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-md-6">
          <div class="product-body">
            <div class="product-label">
              {{-- <span>New</span> --}}
              @if($product->sale)
                <span class="sale">-{{ number_format($product->sale->sale_price) }}%</span>
              @endif
            </div>
            <h2 class="product-name">{{ $product->name }}</h2>
            @if($product->sale)
              <h3 class="product-price">{{ floor($product->price - (($product->price * $product->sale->sale_price)/100)) }} VND <del class="product-old-price">{{ $product->price }} VND</del></h3>
            @else
              <h3 class="product-price">{{ number_format($product->price) }} VND</h3>
            @endif

            <div>{{ __('products.view') }}: {{ $product->view }}</div>
            <div>
              <div class="product-rating">
                @for($i = 1; $i <= $avg; $i++)
                  <i class="fa fa-star"></i>
                @endfor
              </div>
              <a href="#">{{ $countReview }} {{ __('products.review') }}</a>
            </div>
            <p><strong>{{ __('products.status') }}:</strong>@if($product->warehouse->quantity > 0) {{ __('products.stocking') }} @else {{ __('products.outOfStock') }} @endif </p>
            <div><b>{{ __('products.description') }}:</b></div>
            <p>{{ $product->description }}</p>
            {{-- <div class="product-options">
              <ul class="size-option">
                <li><span class="text-uppercase">Size:</span></li>
                <li class="active"><a href="#">S</a></li>
                <li><a href="#">XL</a></li>
                <li><a href="#">SL</a></li>
              </ul>
              <ul class="color-option">
                <li><span class="text-uppercase">Color:</span></li>
                <li class="active"><a href="#" style="background-color:#475984;"></a></li>
                <li><a href="#" style="background-color:#8A2454;"></a></li>
                <li><a href="#" style="background-color:#BF6989;"></a></li>
                <li><a href="#" style="background-color:#9A54D8;"></a></li>
              </ul>
            </div> --}}

            <div class="product-btns">
              <div class="qty-input">
                <span class="text-uppercase">{{ __('orders.quantity') }}: </span>
                <input class="input" type="number" name="quantity" value="1" id="quantity">
              </div>
              @if($product->warehouse->quantity > 0)
                <button class="primary-btn add-to-cart btn-sm" id="add-cart" onclick="addCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale ? floor($product->price - (($product->price * $product->sale->sale_price)/100)) : $product->price }}, '{{ $product->images->first()->image_url }}')">
                      <i class="fa fa-shopping-cart"></i> {{ __('app.addToCart') }}
                  </button>
              @else
                <button class="primary-btn add-to-cart btn-sm hethang" style="background: #999999;">
                  <i class="fa fa-shopping-cart"></i> {{ __('app.hethang') }}
                </button>
              @endif
              <div class="pull-right">
{{--                 <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
                <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
                <button class="main-btn icon-btn"><i class="fa fa-share-alt"></i></button>
 --}}              </div>
              <div class="fb-share-button" 
                data-href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}" 
                data-layout="button_count">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="product-tab">
            <ul class="tab-nav">
              <li class="active"><a data-toggle="tab" href="#tab1">{{ __('products.description') }}</a></li>
              <li><a data-toggle="tab" href="#tab2">{{ __('products.detail') }}</a></li>
              <li><a data-toggle="tab" href="#tab3">{{ __('products.review') }} (<span id="count-review">{{ $countReview }}</span>)</a></li>
            </ul>
            <div class="tab-content">
              <div id="tab1" class="tab-pane fade in active">
                <p>{{ $product->description }}</p>
              </div>
              <div id="tab2" class="tab-pane fade in">
                <p>{!! $product->detail !!}</p>
              </div>
              <div id="tab3" class="tab-pane fade in">
                <div class="row">
                  <div class="col-md-6">
                    <div class="product-reviews">
                      <div id="content-review">
                        @include('products.review')
                      </div>
                      <script type="text/javascript">
                        $(window).on('hashchange', function() {
                              if (window.location.hash) {
                                  var page = window.location.hash.replace('#', '');
                                  if (page == Number.NaN || page <= 0) {
                                      return false;
                                  }else{
                                      getData(page);
                                  }
                              }
                          });
                          
                          $(document).ready(function()
                          {
                              $(document).on('click', '.pagination a',function(event)
                              {
                                  event.preventDefault();
                        
                                  $('li').removeClass('active');
                                  $(this).parent('li').addClass('active');
                        
                                  var myurl = $(this).attr('href');
                                  var page=$(this).attr('href').split('page_review=')[1];
                        
                                  getData(page);
                                  return;
                              });
                        
                          });
                        
                          function getData(page){
                              $.ajax(
                              {
                                  url: '?page_review=' + page,
                                  type: "get",
                                  datatype: "html"
                              }).done(function(data){
                                  $("#content-review").html();
                                  $('#content-review').html(data);
                                  location.hash = page;
                              }).fail(function(jqXHR, ajaxOptions, thrownError){
                                    alert('No response from server');
                              });
                          }
                      </script>


                    </div>
                  </div>
                  <div class="col-md-6">
                    @if(!Auth::check())
                      <a href="{{ route('login') }}" class="btn btn-info">{{ __('app.loginToComment') }}</a>
                    @else
                      <h4 class="text-uppercase">{{ __('products.review') }}</h4>
                      {{ Form::open(['route' => 'reviews.store', 'class' => 'review-form', 'id' => 'review-form']) }}
                        <div class="form-group">
                          <input class="input" id="disabledInput" type="text" placeholder="Your Name" value="{{ Auth::user()->name }}" disabled />
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}" id="product_id">
                        <div class="form-group">
                          <input class="input" id="disabledInput" type="email" placeholder="Email Address" value="{{ Auth::user()->email }}" disabled />
                        </div>
                        <div class="form-group">
                          <textarea class="input" placeholder="Your review" name="content"></textarea>
                        </div>
                        <div class="form-group">
                          <div class="input-rating">
                            <strong class="text-uppercase">{{ __('reviews.rating') }}: </strong>
                            <div class="stars">
                              <input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
                              <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                              <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                              <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                              <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                            </div>
                          </div>
                        </div>
                        <button class="primary-btn">{{ __('products.addReview') }}</button>
                      {{ Form::close() }}
                    @endif
                  </div>
                </div>



              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- /Product Details -->
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
          <h2 class="title">{{ __('app.forYou') }}</h2>
        </div>
      </div>
      <!-- section title -->

      <!-- Product Single -->
      @foreach($moreProducts as $product)
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="product product-single">
          <div class="product-thumb">
            <button class="main-btn quick-view"><i class="fa fa-search-plus"></i><a href="{{ route('frontend.products.show', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ __('app.quickView') }}</a></button>
            <img src="{{ asset('images/products/' . $product->images->first()->image_url) }}" alt="">
          </div>
          <div class="product-body">
            @if($product->sale)
              <h3 class="product-price">{{ floor($product->price - (($product->price * $product->sale->sale_price)/100)) }} VND <del class="product-old-price">{{ $product->price }} VND</del></h3>
            @else
              <h3 class="product-price">{{ $product->price }} VND</h3>
            @endif
            <div class="product-rating">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star-o empty"></i>
            </div>
            <h2 class="product-name"><a href="#">{{ $product->name }}</a></h2>
            <div class="product-btns">
              <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
              <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
              <button class="primary-btn add-to-cart btn-sm"><i class="fa fa-shopping-cart"></i> {{ __('app.addToCart') }}</button>
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
@if(AUth::check())
<div class="modal fade" id="edit-review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('reviews.update') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body review-form">
        {{-- {{ Form::open(['url' => '#', 'class' => 'review-form', 'id' => 'review-form-update']) }} --}}
          <div class="form-group">
            <input class="input" id="disabledInput" type="text" placeholder="Your Name" disabled value="{{ Auth::user()->name }}"/>
          </div>
          <input type="hidden" name="product_id" value="{{ $product->id }}" id="product_id">
          <input type="hidden" name="review_id" id="review_id">
          <div class="form-group">
            <input class="input" id="disabledInput" type="email" placeholder="Email Address" disabled value="{{ Auth::user()->email }}"/>
          </div>
          <div class="form-group">
            <textarea class="input" placeholder="Your review" name="content_update" id="review-edit-content"></textarea>
          </div>
          <div class="form-group">
            <div class="input-rating">
              <strong class="text-uppercase">{{ __('reviews.rating') }}: </strong>
              <div class="stars" id="update-review-rating">
                <input type="radio" id="s5" name="rating_update" value="5" /><label for="s5"></label>
                <input type="radio" id="s4" name="rating_update" value="4" /><label for="s4"></label>
                <input type="radio" id="s3" name="rating_update" value="3" /><label for="s3"></label>
                <input type="radio" id="s2" name="rating_update" value="2" /><label for="s2"></label>
                <input type="radio" id="s1" name="rating_update" value="1" /><label for="s1"></label>
              </div>
            </div>
          </div>
        {{-- </form> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.close') }}</button>
        <button type="submit" class="btn btn-primary" id="save-update">{{ __('app.save') }}</button>
      </div>
      {{-- {{ Form::close() }} --}}
    </div>
  </div>
</div>
@endif
<script type="text/javascript">
   $('.hethang').click(function () {
        alertify.warning('{{ __('app.hethangroi') }}')
    })
</script>
<script type="text/javascript" src="{{ asset('custom/show-product.js') }}"></script>
@endsection
