<div id="navigation">
	<!-- container -->
	<div class="container">
		<div id="responsive-nav">
			<!-- category nav -->
			<div class="category-nav">
				<span class="category-header">{{ __('app.categories') }} <i class="fa fa-list"></i></span>
				<ul class="category-list">
					@foreach($categories2 as $category)
					<li><a href="{{ url("products/search-by-price?category_id=$category->id") }}">{{ $category->name . ' ' . $category->catalog->name }}</a></li>
					@endforeach
				</ul>
			</div>
			<!-- /category nav -->

			<!-- menu nav -->
			<div class="menu-nav">
				<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
				<ul class="menu-list">
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
