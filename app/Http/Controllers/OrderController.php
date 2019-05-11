<?php

namespace App\Http\Controllers;

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
    ) {
        $this->orderRepository = $order;
    }

    public function store(StoreOrderRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user_id = null;
            if (\Auth::check()) {
                $user_id = \Auth::user()->id;
            }
            $data = $request->all();
            $data['total'] = \Cart::subtotal(0,'.','');
            $data['user_id'] = $user_id;
            $order = $this->orderRepository->create($data);
            $carts = \Cart::content();
            $detail = [];
            foreach($carts as $key => $cart) {
                $detail[] = DetailOrder::create([
                    'product_id' => $cart->id,
                    'quantity' => (int)$cart->qty,
                    'order_id' => $order->id,
                    'price' => (int)$cart->price,
                ]);
            }
            \Cart::destroy();
            $link = route('admin.orders.show', ['id' => $order->id]);
            $notify = \App\Notify::create([
                'link' => $link,
                'notify' => __('orders.success'),
            ]);
            event(new \App\Events\OrderEvent(__('orders.success'), $link, $order, $notify->id));
            \DB::commit();
            $order = $order->with(['detailOrders'])->first();

            return redirect()->route('orders.done')->with('status', __('carts.ordersSuccess'));
        } catch (Exception $e) {
            \DB::rollback();
        }
    }

    public function orderDone()
    {
        return view('orders.order-done');
    }

    public function listOrderByUser()
    {
        $user = \Auth::user();
        $orders = $this->orderRepository->listOrderByUser($user->id);

        return view('orders.list-order-by-user', compact('orders'));
    }

    public function detailOrder($id)
    {
        $detailOrders = $this->orderRepository->detailOrder($id);
        $order = $this->orderRepository->findOrFail($id);

        return view('orders.detail', compact('order', 'detailOrders'));
    }

    public function destroy($id)
    {
        $order = $this->orderRepository->destroy($id);
        $link = route('admin.orders.show', ['id' => $id]);
        $notify = \App\Notify::create([
            'link' => $link,
            'notify' => __('orders.deletedOrder'),
        ]);
        event(new \App\Events\OrderEvent(__('orders.deletedOrder'), $link, $order, $notify->id));
        return $order;
    }

    public function listOrderByUserDeleted()
    {
        $user = \Auth::user();
        $orders = $this->orderRepository->listOrderByUserDeleted($user->id);

        return view('orders.list-order-by-user-deleted', compact('orders'));
    }

}
