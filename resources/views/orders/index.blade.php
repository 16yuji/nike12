@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Đơn hàng của tôi</h1>
@if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->count())
  <div class="space-y-4">
  @foreach($orders as $o)
    <div class="border rounded-lg overflow-hidden">
      <div class="bg-gray-50 p-4">
        <div class="flex items-center justify-between">
          <div class="space-y-1">
            <div class="font-medium">Đơn hàng #{{ $o->code }}</div>
            <div class="text-sm text-gray-500">{{ $o->created_at->format('d/m/Y H:i') }}</div>
          </div>
          <div>
            <span class="px-3 py-1 rounded-full text-sm
              @if($o->status == 'pending') bg-yellow-100 text-yellow-800
              @elseif($o->status == 'paid') bg-blue-100 text-blue-800
              @elseif($o->status == 'processing') bg-indigo-100 text-indigo-800
              @elseif($o->status == 'completed') bg-green-100 text-green-800
              @elseif($o->status == 'canceled') bg-red-100 text-red-800
              @endif">
              @switch($o->status)
                  @case('pending') Chờ xác nhận @break
                  @case('paid') Đã thanh toán @break
                  @case('processing') Đang xử lý @break
                  @case('completed') Đã giao hàng @break
                  @case('canceled') Đã hủy @break
                  @default {{ $o->status }} @break
              @endswitch
            </span>
          </div>
        </div>
      </div>
      
      <div class="p-4 space-y-3">
        <div class="text-sm grid grid-cols-2 gap-4">
          <div>
            <div class="text-gray-500">Người nhận:</div>
            <div>{{ $o->shipping_name }}</div>
            <div>{{ $o->shipping_phone }}</div>
            <div>{{ $o->shipping_address }}</div>
          </div>
          <div>
            <div class="text-gray-500">Thanh toán:</div>
            <div>Phương thức: {{ $o->payment_method }}</div>
            <div>Tổng tiền hàng: {{ number_format($o->subtotal) }}₫</div>
            <div>Phí vận chuyển: {{ number_format($o->shipping_fee) }}₫</div>
            <div>Giảm giá: {{ number_format($o->discount) }}₫</div>
            <div class="font-medium">Tổng thanh toán: {{ number_format($o->total) }}₫</div>
          </div>
        </div>

        <div>
          <div class="text-gray-500 text-sm mb-2">Sản phẩm:</div>
          <div class="space-y-2">
            @foreach($o->items as $item)
              <div class="flex items-center gap-4 text-sm">
                <img src="{{ $item->product->mainImage?->path ? asset('storage/'.$item->product->mainImage->path) : 'https://placehold.co/100x100' }}" 
                     class="w-16 h-16 object-cover rounded" alt="{{ $item->product->name }}">
                <div>
                  <div class="font-medium">{{ $item->product->name }}</div>
                  <div class="text-gray-500">
                    {{ number_format($item->unit_price) }}₫ x {{ $item->quantity }}
                  </div>
                </div>
                <div class="ml-auto font-medium">
                  {{ number_format($item->unit_price * $item->quantity) }}₫
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endforeach
  </div>
  <div class="mt-4">{{ $orders->links() }}</div>
@else
  <p>Chưa có đơn hàng.</p>
@endif
@endsection
