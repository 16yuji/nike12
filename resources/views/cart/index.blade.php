@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Giỏ hàng</h1>
@if(!$cart || $cart->items->isEmpty())
  <p>Giỏ hàng trống.</p>
@else
  <form method="POST" action="{{ route('cart.update') }}">
    @csrf
    <table class="w-full text-sm">
      <thead><tr class="border-b"><th class="text-left py-2">Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Tạm tính</th><th></th></tr></thead>
      <tbody>
        @foreach($cart->items as $i)
          <tr class="border-b">
            <td class="py-2 flex items-center gap-3">
              <img class="w-16 h-16 object-cover rounded" src="{{ $i->product->mainImage?->path ? asset('storage/'.$i->product->mainImage->path) : 'https://placehold.co/100x100' }}">
              <div>
                <div class="font-medium">{{ $i->product->name }}</div>
                <div class="text-zinc-500 text-xs">SKU: {{ $i->product->sku }}</div>
              </div>
            </td>
            <td class="text-center">{{ number_format($i->unit_price) }}₫</td>
            <td class="text-center">
              <input type="number" name="items[{{ $i->id }}]" class="border px-2 py-1 w-20 text-center" value="{{ $i->quantity }}" min="1">
            </td>
            <td class="text-center">{{ number_format($i->unit_price * $i->quantity) }}₫</td>
            <td class="text-center">
              <form method="POST" action="{{ route('cart.remove',$i->id) }}">
                @csrf @method('DELETE')
                <button class="text-red-600">Xóa</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-4 flex items-center gap-3">
      <button class="rounded bg-zinc-900 text-white px-4 py-2">Cập nhật</button>
      <a class="rounded bg-black text-white px-4 py-2" href="{{ route('checkout.index') }}">Thanh toán</a>
    </div>
  </form>
@endif
@endsection
