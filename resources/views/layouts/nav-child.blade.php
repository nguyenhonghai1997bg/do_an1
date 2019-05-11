<div id="navigation">
    <!-- container -->
    <div class="container">
        <div id="responsive-nav">
            <div class="menu-nav">
                <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
                <ul class="menu-list">
                    <li><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                    @foreach($catalogs2 as $catalog)
                        <li class="dropdown default-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{ $catalog->name }} <i class="fa fa-caret-down"></i></a>
                            <ul class="custom-menu">
                                @foreach($catalog->categories as $category)
                                <li><a href="{{ url("products/search-by-price?category_id=$category->id") }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- menu nav -->
        </div>
    </div>
    <!-- /container -->
</div>
