<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Cart, CartItem, Product};

class CartController extends Controller
{
    protected function getOrCreateCart(Request $r): Cart
    {
        if (auth()->check()){
            return Cart::firstOrCreate(['user_id'=>auth()->id()]);
        }
        $sid = $r->session()->getId();
        return Cart::firstOrCreate(['session_id'=>$sid]);
    }

    public function index(Request $r)
    {
        $cart = $this->getOrCreateCart($r)->load('items.product.mainImage','items.variant');
        return view('cart.index',compact('cart'));
    }

    public function add(Request $r)
    {
        $data = $r->validate([
            'product_id'=>'required|exists:products,id',
            'variant_id'=>'nullable|exists:product_variants,id',
            'qty'=>'required|integer|min:1'
        ]);
        $cart = $this->getOrCreateCart($r);
        $product = Product::findOrFail($data['product_id']);
        $unit = $product->sale_price ?? $product->price;

        $item = $cart->items()->updateOrCreate(
            ['product_id'=>$product->id,'product_variant_id'=>$data['variant_id'] ?? null],
            ['quantity'=>DB::raw('quantity + '.(int)$data['qty']),'unit_price'=>$unit]
        );
        return back()->with('ok','Đã thêm vào giỏ');
    }

    public function update(Request $r)
    {
        foreach(($r->items ?? []) as $itemId => $qty){
            CartItem::whereKey($itemId)->update(['quantity'=>max(1,(int)$qty)]);
        }
        return back();
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back();
    }
}
