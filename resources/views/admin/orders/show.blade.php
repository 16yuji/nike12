@extends('admin.layout')
@section('content')
<div class="max-w-4xl mx-auto p-4 space-y-4">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Đơn hàng #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
      Quay lại
    </a>
  </div>

  @if(session('ok')) 
    <div class="p-2 bg-green-100 border mb-4">{{ session('ok') }}</div> 
  @endif
  
  <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
    <div class="space-y-2">
      <h2 class="font-semibold">Thông tin khách hàng</h2>
      <div><span class="text-gray-600">Tên:</span> {{ optional($order->user)->name }}</div>
      <div><span class="text-gray-600">Email:</span> {{ optional($order->user)->email }}</div>
    </div>
    
    <div class="space-y-2">
      <h2 class="font-semibold">Thông tin giao hàng</h2>
      <div><span class="text-gray-600">Người nhận:</span> {{ $order->shipping_name }}</div>
      <div><span class="text-gray-600">Số điện thoại:</span> {{ $order->shipping_phone }}</div>
      <div><span class="text-gray-600">Địa chỉ:</span> {{ $order->shipping_address }}</div>
    </div>
  </div>
  
  <div class="flex items-center gap-4">
    <div>Trạng thái hiện tại:</div>
    <div class="font-medium
      @if($order->status == 'pending') text-yellow-600
      @elseif($order->status == 'paid') text-blue-600
      @elseif($order->status == 'processing') text-indigo-600
      @elseif($order->status == 'completed') text-green-600
      @elseif($order->status == 'canceled') text-red-600
      @endif">
      @switch($order->status)
          @case('pending')
              Chờ xác nhận
              @break
          @case('paid')
              Đã thanh toán
              @break
          @case('processing')
              Đang xử lý
              @break
          @case('completed')
              Đã giao hàng
              @break
          @case('canceled')
              Đã hủy
              @break
          @default
              {{ $order->status }}
      @endswitch
    </div>
  </div>

  <div class="flex items-center gap-4 mt-4">
    <div>Cập nhật trạng thái:</div>
    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
      @csrf @method('PATCH')
      <select name="status" class="border rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }} class="text-yellow-600 bg-yellow-50">
          🕒 Chờ xác nhận
        </option>
        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }} class="text-blue-600 bg-blue-50">
          💰 Đã thanh toán
        </option>
        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }} class="text-indigo-600 bg-indigo-50">
          📦 Đang xử lý
        </option>
        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }} class="text-green-600 bg-green-50">
          ✅ Đã giao hàng
        </option>
        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }} class="text-red-600 bg-red-50">
          ❌ Đã hủy
        </option>
      </select>
      <button type="submit" class="
        px-4 py-2 rounded-r
        font-medium
        transition-colors duration-150
        @if($order->status == 'pending') bg-yellow-500 hover:bg-yellow-600
        @elseif($order->status == 'paid') bg-blue-500 hover:bg-blue-600
        @elseif($order->status == 'processing') bg-indigo-500 hover:bg-indigo-600
        @elseif($order->status == 'completed') bg-green-500 hover:bg-green-600
        @elseif($order->status == 'canceled') bg-red-500 hover:bg-red-600
        @endif
        text-blue">
        Cập nhật
      </button>
    </form>
  </div>
  
  <div class="space-y-2 mt-4">
    <h2 class="font-semibold">Thông tin thanh toán</h2>
    <div><span class="text-gray-600">Phương thức thanh toán:</span> {{ $order->payment_method }}</div>
    <div><span class="text-gray-600">Tổng giá trị sản phẩm:</span> {{ number_format($order->subtotal) }}đ</div>
    <div><span class="text-gray-600">Phí vận chuyển:</span> {{ number_format($order->shipping_fee) }}đ</div>
    <div><span class="text-gray-600">Giảm giá:</span> {{ number_format($order->discount) }}đ</div>
    <div class="font-semibold"><span class="text-gray-600">Tổng thanh toán:</span> {{ number_format($order->total) }}đ</div>
  </div>

  <h2 class="font-semibold mt-4">Sản phẩm</h2>
  <div class="overflow-x-auto">
    <table class="w-full border">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 border">Sản phẩm</th>
          <th class="p-2 border">Số lượng</th>
          <th class="p-2 border">Đơn giá</th>
          <th class="p-2 border">Tạm tính</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $it)
        <tr>
          <td class="p-2 border">
            <div class="font-medium">{{ optional($it->product)->name ?? 'N/A' }}</div>
            <div class="text-sm text-gray-500">SKU: {{ optional($it->product)->sku }}</div>
          </td>
          <td class="p-2 border text-center">{{ $it->quantity }}</td>
          <td class="p-2 border text-right">{{ number_format($it->unit_price) }}đ</td>
          <td class="p-2 border text-right">{{ number_format($it->quantity * $it->unit_price) }}đ</td>
        </tr>
        @endforeach
        <tr class="bg-gray-50 font-medium">
          <td colspan="3" class="p-2 border text-right">Tổng giá trị sản phẩm:</td>
          <td class="p-2 border text-right">{{ number_format($order->subtotal) }}đ</td>
        </tr>
        <tr class="bg-gray-50">
          <td colspan="3" class="p-2 border text-right">Phí vận chuyển:</td>
          <td class="p-2 border text-right">{{ number_format($order->shipping_fee) }}đ</td>
        </tr>
        <tr class="bg-gray-50">
          <td colspan="3" class="p-2 border text-right">Giảm giá:</td>
          <td class="p-2 border text-right">{{ number_format($order->discount) }}đ</td>
        </tr>
        <tr class="bg-gray-100 font-bold">
          <td colspan="3" class="p-2 border text-right">Tổng thanh toán:</td>
          <td class="p-2 border text-right">{{ number_format($order->total) }}đ</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
