<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\DetailOrder;
use App\Exports\OrderExport;

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

    public function orderDestroy($id)
    {
        $orderOld = $this->orderRepository->findOrFail($id);
        $order = $this->orderRepository->destroyOrder($id);
        $link = route('users.orders.detail', ['id' => $id]);
        $notify = \App\Notify::create([
            'link' => $link,
            'notify' => __('orders.deletedOrder'),
            'to_user' => $orderOld->user_id ?? null,
        ]);
        if (\Auth::user()) {
            event(new \App\Events\OrderByAdminEvent(__('orders.deletedOrder'), $link, $order, $notify->id, $notify->to_user ?? ''));
        }
        
        return $order;
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

    public function getAllOrdersDone(Request $request)
    {
        $data = [];
        $orders = $this->orderRepository->getAllOrdersDone($request->year);
        $data['orderDone'] = $orders;

        return $data;
    }

    public function getAllOrders(Request $request)
    {
        $orders = $this->orderRepository->getAllOrders($request->year);

        return $orders;
    }


    public function getDataDoughnut(Request $request)
    {
        $orders = $this->orderRepository->getDataDoughnut($request->year);
        
        return $orders;
    }

    public function downloadExcel($type)
    {
        return \Excel::download(new OrderExport, 'order' . date('Y-m-d H:i:s') . '.' . $type);
    }


}
