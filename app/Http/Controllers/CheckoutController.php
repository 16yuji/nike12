<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Order};

class CheckoutController extends Controller
{
    public function index(Request $r)
    {
        $cart = app(CartController::class)->getOrCreateCart($r)->load('items.product','items.variant');
        abort_if($cart->items->isEmpty(), 404);
        return view('checkout.index',compact('cart'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'shipping_name'=>'required','shipping_phone'=>'required','shipping_address'=>'required'
        ]);

        $cart = app(CartController::class)->getOrCreateCart($r)->load('items.product','items.variant');
        abort_if($cart->items->isEmpty(), 404);

        $subtotal = $cart->items->sum(fn($i)=>$i->unit_price * $i->quantity);
        $order = Order::create([
            'user_id'=>auth()->id(),
            'code'=>Str::upper(Str::random(10)),
            'subtotal'=>$subtotal,
            'discount'=>0,
            'shipping_fee'=>0,
            'total'=>$subtotal,
            'status'=>'pending',
            'payment_method'=>'COD',
            ...$data
        ]);

        foreach($cart->items as $i){
            $order->items()->create([
                'product_id'=>$i->product_id,
                'product_variant_id'=>$i->product_variant_id,
                'quantity'=>$i->quantity,
                'unit_price'=>$i->unit_price,
                'line_total'=>$i->unit_price * $i->quantity,
            ]);
        }
        $cart->items()->delete();
        return redirect()->route('orders.index')->with('ok','Đặt hàng thành công!');
    }
}
