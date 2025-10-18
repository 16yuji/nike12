@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-4 space-y-4">
  <h1 class="text-xl font-bold">Đơn hàng #{{ $order->id }}</h1>
  <div>Khách: {{ optional($order->user)->name }} ({{ optional($order->user)->email }})</div>
  <div>Trạng thái: {{ $order->status }}</div>
  <div>Tổng: {{ number_format($order->total_amount ?? 0) }}</div>

  <h2 class="font-semibold mt-4">Sản phẩm</h2>
  <div class="overflow-x-auto">
    <table class="w-full border">
      <thead><tr class="bg-gray-100">
        <th class="p-2 border">SP</th><th class="p-2 border">SL</th><th class="p-2 border">Giá</th><th class="p-2 border">Tạm tính</th>
      </tr></thead>
      <tbody>
        @foreach($order->items as $it)
        <tr>
          <td class="p-2 border">{{ optional($it->product)->name ?? 'N/A' }}</td>
          <td class="p-2 border">{{ $it->quantity }}</td>
          <td class="p-2 border">{{ number_format($it->price) }}</td>
          <td class="p-2 border">{{ number_format($it->quantity * $it->price) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
