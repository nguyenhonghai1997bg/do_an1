<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class HomeController extends Controller
{
	protected $orderRepository;
    protected $userRepository;
    protected $productRepository;

	public function __construct(
        OrderRepositoryInterface $order,
        UserRepositoryInterface $user,
        ProductRepositoryInterface $product
    ) {
		$this->orderRepository = $order;
        $this->userRepository = $user;
        $this->productRepository = $product;
	}

    public function index()
    {
    	$years = $this->orderRepository->getAllYear();
    	$countOrderWaiting = $this->orderRepository->countOrderWaiting();
        $countNewUsers = $this->userRepository->newUsersInMonth();
        $countOrderDeleted = $this->orderRepository->countOrderDeleted();
        $amoutCurrentMonth = $this->orderRepository->amountInMont();
        $topOrderProducts = $this->productRepository->topOrdersAdmin();
        $ordersInCurrentDay = $this->orderRepository->ordersInCurrentDay();

        return view('admin.index', compact('years', 'countOrderWaiting', 'countNewUsers', 'countOrderDeleted', 'amoutCurrentMonth', 'topOrderProducts', 'ordersInCurrentDay'));
    }
}
