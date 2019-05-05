<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\DetailOrder;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct
    (
        OrderRepositoryInterface $order
    )
    {
        $this->orderRepository = $order;
    }

    public function listOrderWaiting()
    {
    	$orders = $this->orderRepository->listOrderWaiting();

        return view('admin.orders.waiting', compact('orders'));
    }

    public function listOrderDone()
    {
        $orders = $this->orderRepository->listOrderDone();

        return view('admin.orders.done', compact('orders'));
    }

    public function listOrderProcess()
    {
        $orders = $this->orderRepository->listOrderProcess();

        return view('admin.orders.process', compact('orders'));
    }

    public function orderDone(Request $request)
    {
        $order = $this->orderRepository->orderDone($request->id);

        return response()->json(['status' => __('orders.done')]);
    }

    public function orderWaiting(Request $request)
    {
        $order = $this->orderRepository->orderWaiting($request->id);

        return response()->json(['status' => __('orders.waiting')]);
    }

    public function orderProcess(Request $request)
    {
        $order = $this->orderRepository->orderProcess($request->id);

        return response()->json(['status' => __('orders.process')]);
    }

    public function listOrderDeleted()
    {
        $orders = $this->orderRepository->listOrderDeleted();

        return view('admin.orders.deleted', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $detailOrders = $this->orderRepository->detailOrder($id);
        $order = $this->orderRepository->findOrFail($id);

        return view('admin.orders.detail', compact('detailOrders', 'order'));
    }
}
