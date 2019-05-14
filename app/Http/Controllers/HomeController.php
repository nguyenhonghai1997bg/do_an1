<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;


class HomeController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $product, CategoryRepositoryInterface $category)
    {
        $this->productRepository = $product;
        $this->categoryRepository = $category;
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
        $topOrders = $this->productRepository->topOrders();

        return view('home', compact('latestProducts', 'topViewtProducts', 'topSale', 'topOrders'));
    }
}
