@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Thanh toán</h1>
@if($cart->items->isEmpty())
  <p>Giỏ hàng trống.</p>
@else
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <form method="POST" action="{{ route('checkout.store') }}" class="md:col-span-2">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm">Họ tên</label>
          <input class="border px-3 py-2 w-full" name="shipping_name" required>
        </div>
        <div>
          <label class="block text-sm">Số điện thoại</label>
          <input class="border px-3 py-2 w-full" name="shipping_phone" required>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm">Địa chỉ</label>
          <input class="border px-3 py-2 w-full" name="shipping_address" required>
        </div>
      </div>
      <button class="mt-6 rounded bg-black text-white px-4 py-2">Đặt hàng (COD)</button>
    </form>
    <aside>
      <div class="border rounded p-4">
        <h2 class="font-semibold mb-3">Đơn hàng</h2>
        @php $subtotal = $cart->items->sum(fn($i)=>$i->unit_price * $i->quantity); @endphp
        <div class="flex justify-between"><span>Tạm tính</span><span>{{ number_format($subtotal) }}₫</span></div>
        <div class="flex justify-between"><span>Giảm giá</span><span>0₫</span></div>
        <div class="flex justify-between"><span>Phí vận chuyển</span><span>0₫</span></div>
        <div class="flex justify-between font-semibold mt-2"><span>Tổng</span><span>{{ number_format($subtotal) }}₫</span></div>
      </div>
    </aside>
  </div>
@endif
@endsection
