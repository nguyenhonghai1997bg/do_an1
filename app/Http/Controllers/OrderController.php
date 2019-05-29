<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\DetailOrder;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccess;

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
        if ($request->ship == -1) {
            return redirect()->back()->with('error', __('orders.address_not_found'));
        }
        if (\Cart::subtotal(0,'.','') == 0) {
            return redirect()->back()->with('error', __('orders.error_total_cart'));
        }
        \DB::beginTransaction();
        try {
            $user_id = null;
            if (\Auth::check()) {
                $user_id = \Auth::user()->id;
            }
            $data = $request->all();
            if ($request->paymethod_id == 2 && is_null($request->bankcode)) {
                return redirect()->back()->with('error', __('orders.error_bankcode'));
            }

            if(!is_null($request->bankcode)) {
                $bankCode = $request->bankcode;
            }
            if(is_null($data['bankcode']) || isset($data['bankcode'])) {
                unset($data['bankcode']);
            }
            $data['total'] = \Cart::subtotal(0,'.','') + $request->ship;
            if (isset($data['ship'])) {
                unset($data['ship']);
            }
            $data['user_id'] = $user_id;
            $order = $this->orderRepository->create($data);
            $carts = \Cart::content();
            $detail = [];
            foreach($carts as $key => $cart) {
                $product22 = \App\Product::findOrFail($cart->id);
                if ($product22->warehouse->quantity - (int)$cart->qty < 0) {
                    return redirect()->back()->with('warning', 'Sản phẩm ' . $product22->name . ' chỉ còn ' . $product22->warehouse->quantity . ' sản phẩm');
                }
                $detail[] = DetailOrder::create([
                    'product_id' => (int)$cart->id,
                    'quantity' => (int)$cart->qty,
                    'order_id' => (int)$order->id,
                    'price' => (int)$cart->price,
                ]);
                $product = \App\Product::findOrFail((int)$cart->id);
                $product->warehouse->quantity = $product->warehouse->quantity - (int)$cart->qty;
                $product->warehouse->save();
            }
            \Cart::destroy();
            $link = route('admin.orders.show', ['id' => $order->id]);
            $notify = \App\Notify::create([
                'link' => $link,
                'notify' => __('orders.success'),
            ]);
            event(new \App\Events\OrderEvent(__('orders.success'), $link, $order, $notify->id));
            // $sendToPhone = '+84' . substr($order->phone, 1, 9);
            // $account_sid = 'AC48892300f8a8224ced9a1332fc3ffa8c';
            // $auth_token = '2e39fee797e0626906bb3d80a4f0e438';
            // $twilio_number = "+14044452121";
            // $client = new Client($account_sid, $auth_token);
            // $client->messages->create(
            //     // Where to send a text message (your cell phone?)
            //     "+84392660985",
            //     array(
            //         'from' => $twilio_number,
            //         'body' => __('orders.success')
            //     )
            // );

            \DB::commit();
            // $order = $order->with(['detailOrders'])->first();

            if ($request->paymethod_id == 2) { //thanh toán qua ngân hang
                $url = $this->getUrlPeymethod($order, $bankCode);

                return redirect($url);
            }
            Mail::to($request->email)->send(new OrderSuccess($order));
            
            return redirect()->route('orders.done')->with('status', __('carts.ordersSuccess'));
        } catch (Exception $e) {
            \DB::rollback();
        }
    }

    //thanh toán qua ngân hàng
    public function getUrlPeymethod($order, $bankCode)
    {
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay_return', ['order_id' => $order->id]);
        $vnp_TmnCode = "6SU1J9O6";//Mã website tại VNPAY 
        $vnp_HashSecret = "QNWIBZTBPKBATOISWDAMVATZOEHOWIVT"; //Chuỗi bí mật
        $vnp_TxnRef = $order->id;//Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán mua hàng';
        $vnp_Amount = $order->total;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,   
            "vnp_OrderInfo" => $vnp_OrderInfo,
            'vnp_BankCode' => $bankCode,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,     
        );
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256',$vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return  $vnp_Url;
    }

    public function vnpayReturn(Request $request, $order_id)
    {
        $order = $this->orderRepository->findOrFail($order_id);
        $vnp_SecureHash = $request->vnp_SecureHash;
        $vnp_HashSecret = "QNWIBZTBPKBATOISWDAMVATZOEHOWIVT";
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            $inputData[$key] = $value;
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = hash('sha256',$vnp_HashSecret . $hashData);
        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $order->update([
                    'is_paymented' => 1,
                ]);
                Mail::to($order->email)->send(new OrderSuccess($order, 1));//1 là trạng thái đã thanh toán

                return redirect()->route('orders.done')->with('status', __('carts.ordersSuccess'));
            } else {
                echo "GD Khong thanh cong";
            }
        } else {
            echo "Chu ky khong hop le";
        }
        return;
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
        $order = $this->orderRepository->destroyOrder($id);
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
