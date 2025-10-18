<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // đảm bảo có model Order
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $orders = Order::with('user')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate(12)->withQueryString();

        return view('admin.orders.index', compact('orders','status'));
    }

    public function show(Order $order)
    {
        $order->load(['user','items.product']); // items: quan hệ chi tiết đơn hàng
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending','paid','processing','completed','canceled'])],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('ok', 'Đã cập nhật trạng thái đơn hàng.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('ok','Đã xóa đơn hàng.');
    }
}
