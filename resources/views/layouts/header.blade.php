<header>
    <?php $carts = \Cart::content() ?? null ?>
    <!-- top Header -->
    <div id="top-header">
        <div class="container">
            <div class="pull-left">
                <span>Welcome to Masha life shop!</span>
            </div>
            <div class="pull-right">
                <ul class="header-top-links">
                    <li class="dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">ENG <i class="fa fa-caret-down"></i></a>
                        <ul class="custom-menu">
                            <li><a href="#">English (ENG)</a></li>
                            <li><a href="#">Viet Nam (VI)</a></li>
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
                        <img src=" {{ asset('users/img/logo.png') }}" alt="">
                    </a>
                </div>
                <!-- /Logo -->

                <!-- Search -->
                <div class="header-search">
                    <form action="{{ route('users.search') }}">
                        <input class="input search-input" type="search" name="key" placeholder="Enter your keyword" id="input-search" value="{{ request('key', '') }}">
                        <select class="input search-categories" name="category_id">
                            <option value="0">All Categories</option>
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
                    <li class="header-account dropdown default-dropdown">
                        <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <strong class="text-uppercase">{{ !empty(Auth::user()) ? Auth::user()->name : __('app.Accout') }}<i class="fa fa-caret-down"></i></strong>
                        </div>
                        @if(empty(Auth::user()))
                        <a href="#" class="text-uppercase">Login</a> / <a href="#" class="text-uppercase">Join</a>
                        <ul class="custom-menu">
                            <li><a href="#"><i class="fa fa-user-o"></i> My Account</a></li>
                            <li><a href="#"><i class="fa fa-heart-o"></i> My Wishlist</a></li>
                            <li><a href="#"><i class="fa fa-exchange"></i> Compare</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Checkout</a></li>
                            <li><a href="#"><i class="fa fa-unlock-alt"></i> Login</a></li>
                            <li><a href="#"><i class="fa fa-user-plus"></i> Create An Account</a></li>
                        </ul>
                        @else
                            <ul class="custom-menu">
                                <li><a href="#"><i class="fa fa-user-o"></i>{{ __('users.profile') }}</a></li>
                                <li><a href="{{ route('users.show.list-order') }}"><i class="fa fa-heart-o"></i>{{ __('users.listOrders') }}</a></li>
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
                                                    <img src="{{ $cart->options ? $cart->options->image_url : '' }}" alt="">
                                                </div>
                                                <div class="product-body">
                                                    <h3 class="product-price">
                                                        <span id="item-{{ $cart->rowId }}-price">{{ number_format($cart->price) }}</span>
                                                        <span class="qty">x<span id="item-{{ $cart->rowId }}-qty">{{ $cart->qty }}</span></span>
                                                    </h3>
                                                    <h2 class="product-name"><a href="product-page.html">{{ $cart->name }}</a></h2>
                                                </div>
                                                <button class="cancel-btn" onclick="deleteCart({{ $cart->id }}, '{{ $cart->rowId }}', '{{ __('app.confirm') }}', '{{ __('cart.confirm') }}')"><i class="fa fa-trash"></i></button>
                                            </div>
                                        @endforeach
                                        @endif
                                    </div>
                                {{-- @endif --}}
                                <div class="shopping-cart-btns">
                                    <a class="primary-btn" href="{{ route('carts.checkout') }}">{{ __('cart.checkout') }} <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
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
