<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class HomeController extends Controller
{
	protected $orderRepository;
    protected $userRepository;

	public function __construct(OrderRepositoryInterface $order, UserRepositoryInterface $user)
	{
		$this->orderRepository = $order;
        $this->userRepository = $user;
	}

    public function index()
    {
    	$years = $this->orderRepository->getAllYear();
    	$countOrderWaiting = $this->orderRepository->countOrderWaiting();
        $countNewUsers = $this->userRepository->newUsersInMonth();
        $countOrderDeleted = $this->orderRepository->countOrderDeleted();
        $amoutCurrentMonth = $this->orderRepository->amountInMont();

        return view('admin.index', compact('years', 'countOrderWaiting', 'countNewUsers', 'countOrderDeleted', 'amoutCurrentMonth'));
    }
}
