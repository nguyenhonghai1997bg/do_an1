<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\DetailOrder\DetailOrderRepositoryInterface;
use App\Order;

class OrderRepository extends RepositoryEloquent implements OrderRepositoryInterface
{
    public $perPage;
    public $detailOrderRepository;

    public function __construct(Order $order, DetailOrderRepositoryInterface $detail)
    {
        $this->detailOrderRepository = $detail;
        $this->perPageDetail = \App\DetailOrder::PERPAGE;
        $this->model = $order;
        $this->perPage = $this->model::PERPAGE;
    }

    public function listOrderWaiting()
    {
        $orders = $this->model->isNotDelete()->where('status', $this->model::WAITING)->with(['detailOrders', 'user'])->paginate($this->perPage);

        return $orders;
    }

    public function listOrderDone()
    {
        $orders = $this->model->isNotDelete()->where('status', $this->model::DONE)->with(['detailOrders', 'user'])->paginate($this->perPage);

        return $orders;
    }

    public function listOrderProcess()
    {
        $orders = $this->model->isNotDelete()->where('status', $this->model::PROCESS)->with(['detailOrders', 'user'])->paginate($this->perPage);

        return $orders;
    }

    public function orderDone($id)
    {
        $order = $this->model->isNotDelete()->findOrFail($id);
        $order->status = $this->model::DONE;
        $order->save();

        return $order;
    }

    public function orderWaiting($id)
    {
        $order = $this->model->isNotDelete()->findOrFail($id);
        $order->status = $this->model::WAITING;
        $order->save();

        return $order;
    }

    public function orderProcess($id)
    {
        $order = $this->model->isNotDelete()->findOrFail($id);
        $order->status = $this->model::PROCESS;
        $order->save();

        return $order;
    }

    public function listOrderDeleted()
    {
        $orders = $this->model->isDeleted()->paginate($this->perPageDetail);

        return $orders;
    }

    public function detailOrder($id, $search = '')
    {
        $order = $this->detailOrderRepository->where('order_id', $id)->orderBy('id', 'DESC')->paginate($this->perPageDetail);

        return $order;
    }

    public function listOrderByUser($id)
    {
        $orders = $this->model->where('user_id', $id)->whereNull('deleted_at')->paginate($this->perPage);

        return $orders;
    }

    public function listOrderByUserDeleted($id)
    {
        $orders = $this->model->where('user_id', $id)->whereNotNull('deleted_at')->paginate($this->perPage);

        return $orders;
    }

    public function destroy($id)
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $order = $this->model->findOrFail($id);
        if (!$order->status == \App\Order::WAITING)
        {
            return response()->json(['error' => __('orders.notDelete')]);
        } else {
            $order->deleted_at = $now;
            $order->save();

            return response()->json(['status' => __('orders.deleted')]);
        }
    }



}
