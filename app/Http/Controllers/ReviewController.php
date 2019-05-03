<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Repositories\Review\ReviewRepositoryInterface;

class ReviewController extends Controller
{
    protected $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function store(StoreReviewRequest $request)
    {
        if ($this->reviewRepository->where('user_id', \Auth::user()->id)->where('product_id', $request->product_id)->exists()) {
            return response()->json(['error' => __('review.reviewExists')]);
        }
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        $review = $this->reviewRepository->create($data);
        $review['user'] = $review->user;

        return $review;
    }

    public function update(UpdateReviewRequest $request)
    {
        $review = $this->reviewRepository->findOrFail($request->id);
        $this->authorize('update', $review);
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        $review = $this->reviewRepository->update($data, $request->id);
        $review['user'] = $review->user;

        return response()->json(['status' => __('reviews.updated')]);
    }

    public function destroy($id)
    {
        $review = $this->reviewRepository->findOrFail($id);
        $this->authorize('delete', $review);
        $this->reviewRepository->destroy($id);

        return response()->json(['status' => __('reviews.deleted')]);
    }
}
