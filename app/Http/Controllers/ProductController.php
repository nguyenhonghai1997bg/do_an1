<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Review\ReviewRepositoryInterface;

class ProductController extends Controller
{
	protected $productRepository;
    protected $reviewRepository;

	public function __construct(
        ProductRepositoryInterface $productRepository,
        ReviewRepositoryInterface $reviewRepository
    )
	{
		$this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
	}

    public function show($id)
    {
    	$product = $this->productRepository->with('images')->findOrFail($id);
    	$moreProducts = $this->productRepository->moreProduct($id, $product->price, $product->category_id);
        $reviews = $product->reviews()->orderBy('id', 'DESC')->paginate(4);
        $countReview = $this->reviewRepository->where('product_id', $id)->count();

    	return view('products.show', compact('product', 'moreProducts', 'reviews', 'countReview'));
    }
}
