<?php

namespace App\Http\Controllers;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ? auth()->user()->orders()->with('items.product')->latest()->paginate(20)
            : collect();
        return view('orders.index', compact('orders'));
    }
}
