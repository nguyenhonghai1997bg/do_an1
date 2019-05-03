<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;

class HomeController extends Controller
{
    protected $productRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $product)
    {
        $this->productRepository = $product;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latestProducts = $this->productRepository->latestProducts();
        $topViewtProducts = $this->productRepository->topviewtProducts();
        $topSale = $this->productRepository->topSale();

        return view('home', compact('latestProducts', 'topViewtProducts', 'topSale'));
    }
}
