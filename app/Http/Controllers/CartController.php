<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCartRequest;
use Cart;

class CartController extends Controller
{
    public function store(StoreCartRequest $request)
    {
    	$cart = Cart::add([
            'id' => $request->product_id,
            'name' => $request->name,
            'weight' => null,
            'qty' => $request->quantity,
            'price' => (int)$request->price,
            'options' => [
                'image_url' => $request->image_url
            ]
        ]);
        $cart = $cart->toArray();
        $cart['count'] = Cart::content()->count();

        return $cart;
    }

    public function destroy($id)
    {
        Cart::remove($id);
        $subtotal = number_format(\Cart::subtotal(0,'.',''));

        return response()->json(['status' => 'carts.deleted', 'subtotal' => $subtotal]);
    }

    public function checkout()
    {
        return view('orders.checkout');
    }

    public function update(Request $request)
    {
        $cart = Cart::update($request->rowId, ['qty' => $request->qty]);
        $cart_total = number_format($cart->price * $cart->qty);
        $subtotal = number_format(\Cart::subtotal(0,'.',''));

        return response()->json(['status' => 'carts.updated', 'cart_total' => $cart_total, 'subtotal' => $subtotal]);
    }
}
