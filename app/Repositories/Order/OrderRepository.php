<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\DetailOrder\DetailOrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Order;

class OrderRepository extends RepositoryEloquent implements OrderRepositoryInterface
{
    public $perPage;
    public $detailOrderRepository;
    public $productRepository;

    public function __construct(Order $order, DetailOrderRepositoryInterface $detail, ProductRepositoryInterface $productRepository)
    {
        $this->detailOrderRepository = $detail;
        $this->perPageDetail = \App\DetailOrder::PERPAGE;
        $this->model = $order;
        $this->perPage = $this->model::PERPAGE;
        $this->productRepository = $productRepository;
    }

    public function listOrderWaiting()
    {
        $orders = $this->model->isNotDelete()->where('status', $this->model::WAITING)->with(['detailOrders', 'user'])->paginate($this->perPage);

        return $orders;
    }

    public function listOrderDone()
    {
        $orders = $this->model->isNotDelete()->where('status', $this->model::DONE)->with(['detailOrders', 'user'])->orderBy('updated_at', 'DESC')->paginate($this->perPage);

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
        $orders = $this->model->isDeleted()->orderBy('deleted_at', 'DESC')->paginate($this->perPageDetail);

        return $orders;
    }

    public function detailOrder($id, $search = '')
    {
        $order = $this->detailOrderRepository->where('order_id', $id)->orderBy('id', 'DESC')->paginate($this->perPageDetail);

        return $order;
    }

    public function listOrderByUser($id)
    {
        $orders = $this->model->where('user_id', $id)->whereNull('deleted_at')->orderBy('id', 'DESC')->paginate($this->perPage);

        return $orders;
    }

    public function listOrderByUserDeleted($id)
    {
        $orders = $this->model->where('user_id', $id)->whereNotNull('deleted_at')->paginate($this->perPage);

        return $orders;
    }

    public function destroyOrder($id)
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $order = $this->model->findOrFail($id);
        foreach ($order->detailOrders as $key => $detailOrder) {
            $product = $this->productRepository->findOrFail($detailOrder->product_id);
            $product->warehouse->quantity += $detailOrder->quantity;
            $product->warehouse->save();
        }
        if (!$order->status == \App\Order::WAITING)
        {
            return response()->json(['error' => __('orders.notDelete')]);
        } else {
            $order->deleted_at = $now;
            $order->deleted_by = \Auth::user()->name . '(' . \Auth::user()->role->name . ')';
            $order->save();

            return response()->json(['status' => __('orders.deleted'), 'user_id' => $order->user_id ?? null]);
        }
    }

    public function getAllYear()
    {
        $years = $this->model->select(\DB::raw('YEAR(created_at) AS year'))->orderBy('year', 'DESC')->distinct()->get();

        return $years;
    }

    public function getAllOrdersDone($year)
    {
        $money =  $this->model->isNotDelete()->select(\DB::raw('sum(total) as money, MONTH(created_at) as month'))->whereYear('created_at', $year)->where('status', $this->model::DONE)->groupBy(\DB::raw('MONTH(created_at)'))->get();
        $result = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0];
        foreach ($money as $value) {
            if($value->month) {
                $result[$value->month] = $value->money;
            }
        }
        
        return $result;
    }

    public function getAllOrders($year)
    {
        $money =  $this->model->isNotDelete()->select(\DB::raw('sum(total) as money, MONTH(created_at) as month'))->whereYear('created_at', $year)->groupBy(\DB::raw('MONTH(created_at)'))->get();
        $result = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0];
        foreach ($money as $value) {
            if($value->month) {
                $result[$value->month] = $value->money;
            }
        }
        
        return $result;
    }

    public function getDataDoughnut($year)
    {
        $done = $this->model->isNotDelete()->where('status', $this->model::DONE)->whereYear('created_at', $year)->count();
        $process = $this->model->isNotDelete()->where('status', $this->model::PROCESS)->whereYear('created_at', $year)->count();
        $waiting = $this->model->isNotDelete()->where('status', $this->model::WAITING)->whereYear('created_at', $year)->count();
        $cancel = $this->model->isDeleted()->whereYear('created_at', $year)->count();
    
        return response()->json(['done' => $done, 'process' => $process, 'waiting' => $waiting, 'cancel' => $cancel]);
    }

    public function countOrderWaiting()
    {
        return $this->model->isNotDelete()->where('status', $this->model::WAITING)->count();
    }

    public function countOrderDeleted()
    {
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;

        return $this->model->whereNotNull('deleted_at')->where(\DB::raw('MONTH(created_at)'), $currentMonth)->where(\DB::raw('YEAR(created_at)'), $currentYear)->count();
    }

    public function amountInMont()
    {
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;

        return $this->model->isNotDelete()->select(\DB::raw('sum(total) as money'))->where('status', $this->model::DONE)->where(\DB::raw('MONTH(created_at)'), $currentMonth)->where(\DB::raw('YEAR(created_at)'), $currentYear)->groupBy(\DB::raw('MONTH(created_at)'))->first();
    }

    public function ordersDoneDownload()
    {
        return $this->model->isNotDelete()->where('status', $this->model::DONE)->get()->toArray();
    }

    public function ordersInCurrentDay()
    {
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;
        $currentDay = \Carbon\Carbon::now()->day;
        $ordersDone = $this->model->isNotDelete()->where(\DB::raw('MONTH(created_at)'), $currentMonth)->where(\DB::raw('YEAR(created_at)'), $currentYear)->where(\DB::raw('DAY(created_at)'), $currentDay)->where('status', $this->model::DONE)->count();
        $ordersProcess = $this->model->isNotDelete()->where(\DB::raw('MONTH(created_at)'), $currentMonth)->where(\DB::raw('YEAR(created_at)'), $currentYear)->where(\DB::raw('DAY(created_at)'), $currentDay)->where('status', $this->model::PROCESS)->count();

        $ordersWaiting = $this->model->isNotDelete()->where(\DB::raw('MONTH(created_at)'), $currentMonth)->where(\DB::raw('YEAR(created_at)'), $currentYear)->where(\DB::raw('DAY(created_at)'), $currentDay)->where('status', $this->model::WAITING)->count();

        $ordersDelete = $this->model->isDeleted()->where(\DB::raw('MONTH(created_at)'), $currentMonth)->where(\DB::raw('YEAR(created_at)'), $currentYear)->where(\DB::raw('DAY(created_at)'), $currentDay)->count();

        $list = [];
        $list['ordersDone'] = $ordersDone;
        $list['ordersProcess'] = $ordersProcess;
        $list['ordersWaiting'] = $ordersWaiting;
        $list['ordersDelete'] = $ordersDelete;

        return $list;
    }
}
