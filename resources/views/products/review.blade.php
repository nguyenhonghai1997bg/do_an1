@foreach($reviews as $review)
  <div class="single-review" id="review-{{ $review->id }}">
    <div class="review-heading">
      <div><a href="#"><i class="fa fa-user-o"></i>{{ $review->user->name }}</a></div>
      <div>
        <a href="#"><i class="fa fa-clock-o"></i>{{ $review->created_at }}</a>
          @if(Auth::user() && Auth::user()->id == $review->user->id)
            <a href="#" class="mt-2 ml-5" onclick="showModalEditReview({{ $review->id }}, {{ $review->product_id }}, '{{ $review->content }}', {{ $review->rating }})">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
          @endif
        @if(Auth::user() && Auth::user()->id == $review->user->id)
          <a href="#" class="mt-2 ml-5" onclick="deleteReview('{{ __('reviews.delete') }}','{{ __('app.confirm') }}', {{ $review->id }})">
              <i class="fa fa-trash" aria-hidden="true"></i>
          </a>
          @endif
      </div>
      <div class="review-rating pull-right" id="rating-{{ $review->id }}">
        @for($i = 1; $i <= $review->rating; $i++)
          <i class="fa fa-star"></i>
        @endfor
      </div>
    </div>
    <div class="review-body">
      <p id="content-{{ $review->id }}">{{ $review->content }}</p>
    </div>
  </div>
@endforeach
{!! $reviews->render() !!}
