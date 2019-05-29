<header>
    <?php $carts = \Cart::content() ?? null ?>
    <!-- top Header -->
    <div id="top-header">
        <div class="container">
            <div class="pull-left">
            <span>{{ __('app.welcome') }}</span>
            </div>
            <div class="pull-right">
                <ul class="header-top-links">
                    <li class="dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{ Config::get('app.locale') == 'vi' ? 'Tiếng Việt' : 'ENG'  }} <i class="fa fa-caret-down"></i></a>
                        <ul class="custom-menu">
                            @if(Config::get('app.locale') == 'vi')
                                <li><a href="{{ route('set_locale', ['locale' => 'en']) }}">English (ENG)</a></li>
                            @else
                                <li><a href="{{ route('set_locale', ['locale' => 'vi']) }}">Viet Nam (VI)</a></li>
                            @endif
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
    <!-- /top Header -->

    <!-- header -->
    <div id="header">
        <div class="container">
            <div class="pull-left">
                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="{{ route('home') }}">
                        <img src="{{ asset('images/masha-life.png') }}" alt="">
                    </a>
                </div>
                <!-- /Logo -->

                <!-- Search -->
                <div class="header-search">
                    <form action="{{ route('users.search') }}">
                    <input class="input search-input" type="search" name="key" placeholder="{{ __('app.search') }}" id="input-search" value="{{ request('key', '') }}">
                        <select class="input search-categories" name="category_id">
                        <option value="0">{{ __('categories.allCategories') }}</option>
                            @foreach($categories2 as $category)
                            <option value="{{ $category->id }}" {{ request('category_id', 0) == $category->id ? 'selected' : '' }}>{{ $category->name . ' ' . $category->catalog->name }}</option>
                            @endforeach
                        </select>
                        <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!-- /Search -->
            </div>
            <div class="pull-right">
                <ul class="header-btns">
                    <!-- Account -->
                    <li class="header-cart dropdown default-dropdown">
                        <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <strong class="text-uppercase">{{ !empty(Auth::user()) ? Auth::user()->name : __('app.Accout') }}<i class="fa fa-caret-down"></i></strong>
                        </div>
                        @if(empty(Auth::user()))
                        <a href="#" class="text-uppercase">{{ __('app.login') }}</a>
                        <ul class="custom-menu">
                            <li><a href="{{ route('login') }}"><i class="fa fa-unlock-alt"></i> {{ __('app.login') }}</a></li>
                            <li><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> {{ __('app.register') }}</a></li>
                        </ul>
                        @else
                            <ul class="custom-menu">
                                <li><a href="{{ route('users.edit_profile') }}"><i class="fa fa-user-o"></i>{{ __('users.profile') }}</a></li>
                                <li><a href="{{ route('users.show.list-order') }}"><i class="fa fa-heart-o"></i>{{ __('users.listOrders') }}</a></li>
                                <li><a href="{{ route('users.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>{{ __('users.logout') }}</a></li>
                            </ul>
                        @endif
                    </li>
                    <!-- /Account -->

                    <!-- Cart -->
                    <li class="header-cart dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="qty" id="qty">{{ \Cart::content() ? \Cart::content()->count() : 0 }}</span>
                            </div>
                            <strong class="text-uppercase">{{ __('app.myCart') }}:</strong>
                            <br>
                            <span id="subtotal">{{ \Cart::subtotal() ? number_format(\Cart::subtotal(0,'.','')) : 0 }}</span><span>VND</span>
                        </a>
                        <div class="custom-menu">
                            <div id="shopping-cart">
                                <div class="shopping-cart-list" id="shopping-cart-list">
                                    @if ($carts != null)
                                    @foreach($carts as $cart)
                                        <div class="product product-widget" id="cart-{{ $cart->rowId }}">
                                            <div class="product-thumb">
                                                <img src="{{ $cart->options ? asset('images/products/' . $cart->options->image_url) : '' }}" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-price">
                                                    <span id="item-{{ $cart->rowId }}-price">{{ number_format($cart->price) }}</span>
                                                    <span class="qty">x<span id="item-{{ $cart->rowId }}-qty">{{ $cart->qty }}</span></span>
                                                </h3>
                                                <h2 class="product-name"><a href="#">{{ $cart->name }}</a></h2>
                                            </div>
                                            <button class="cancel-btn" onclick="deleteCart({{ $cart->id }}, '{{ $cart->rowId }}', '{{ __('app.confirm') }}', '{{ __('cart.confirm') }}')"><i class="fa fa-trash"></i></button>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="shopping-cart-btns">
                                    <a class="primary-btn" href="{{ route('carts.checkout') }}">{{ __('carts.checkout') }} <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>

                    @if(Auth::check())
                    <li class="header-cart dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-bell"></i>
                                <?php
                                    if(Auth::user()) {
                                        $notifiesUser = \App\Notify::where('to_user', Auth::user()->id)->where('status', 0)->take('6')->get();
                                        $count = \App\Notify::where('to_user', Auth::user()->id)->where('status', 0)->count();
                                    }
                                ?>
                                <span class="qty" id="count-notifies">{{ $count }}</span>
                            </div>
                            <br>
                        </a>
                        <div class="custom-menu">
                            <div id="shopping-cart">
                                <div class="shopping-cart-list" id="notify-user-list">
                                    @if ($notifiesUser != null)
                                        @foreach($notifiesUser as $notify)
                                            <a href="{{ $notify->link }}" class="mt-2" onclick="seen({{ $notify->id }})"><div>{{ $notify->notify }}</div></a>
                                        @endforeach
                                    @endif
                                </div>
                                <hr>
                                <a href="{{ route('users.allNotifies') }}">{{ __('app.viewAll') }}</a>
                            </div>
                        </div>
                    </li>
                    @endif
                    <!-- /Cart -->

                    <!-- Mobile nav toggle-->
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                    </li>
                    <!-- / Mobile nav toggle -->
                </ul>
            </div>
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>

@if(Auth::check())
<script type="text/javascript">
    var pusher = new Pusher('a70261703ef25d858f99', {
      encrypted: true,
      cluster: 'ap1',
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('admin-order-channel' + {{ Auth::user()->id }});

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\OrderByAdminEvent', function(data) {
        $('#notify-user-list').prepend('<a href="' + data.link + '" class="mt-2" onclick="seen(' + data.notify_id + ')"><div>' + data.notify + '</div></a>')
            
        var countNotify = parseInt($('#count-notifies').text());
        console.log(data)
        $('#count-notifies').text(countNotify + 1)
        Push.create(data.notify, {
            body: data.notify,
            icon: "{{ asset('images/logo.jpg') }}",
            timeout: 5000,
            onClick: function() {
                window.focus();
                window.location.href = data.link
            }
          });
        alertify.success(data.notify)
    });
    function seen(id) {
      $.ajax({
        url: window.location.origin + '/admin/manager/notifies/seen/' + id,
        method: 'POST'
      })
    }
</script>
@endif
