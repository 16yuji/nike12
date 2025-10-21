@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto">
  <!-- Tab Navigation -->
  <div class="border-b mb-6">
    <div class="flex gap-8">
      <a href="#cart" onclick="showTab('cart')" class="tab-button pb-4 px-2 font-medium text-lg border-b-2 border-black">Giỏ hàng</a>
      <a href="#history" onclick="showTab('history')" class="tab-button pb-4 px-2 font-medium text-lg border-b-2 border-transparent text-gray-500 hover:text-black">Lịch sử đặt hàng</a>
    </div>
  </div>

  <!-- Giỏ hàng Tab -->
  <div id="cart-tab">
    <div class="lg:col-span-2">
      <h1 class="text-2xl font-semibold mb-4">Giỏ hàng</h1>
    @if(!$cart || $cart->items->isEmpty())
      <p class="bg-gray-50 rounded-lg p-8 text-center text-gray-500">Giỏ hàng trống.</p>
    @else
  <form method="POST" action="{{ route('cart.update') }}" id="update-cart-form">
    @csrf
    @if(session('ok'))<div class="p-2 bg-green-100 border my-2">{{ session('ok') }}</div>@endif
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
              <form method="POST" action="{{ route('cart.remove', $i->id) }}" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <a href="{{ route('orders.index') }}" class="rounded bg-zinc-900 text-white px-4 py-2 hover:bg-zinc-800">
          Lịch sử đặt hàng
        </a>
        <a class="rounded bg-black text-white px-4 py-2 hover:bg-gray-900" href="{{ route('checkout.index') }}">
          Thanh toán
        </a>
      </div>
      <div class="text-right">
        <div class="text-lg font-semibold">Tổng cộng:</div>
        <div class="text-2xl font-bold">{{ number_format($cart->items->sum(fn($i) => $i->unit_price * $i->quantity)) }}₫</div>
      </div>
    </div>
  </form>
@endif
  </div>

  </div>

  <!-- Lịch sử đặt hàng Tab -->
  <div id="history-tab" class="hidden">
    <h2 class="text-2xl font-semibold mb-4">Lịch sử đơn hàng</h2>
    @if(auth()->check() && auth()->user()->orders()->exists())
      <div class="space-y-4">
        @foreach(auth()->user()->orders()->latest()->take(5)->get() as $order)
          <div class="border rounded-lg overflow-hidden bg-white">
            <div class="p-4">
              <div class="flex items-center justify-between">
                <div class="space-y-1">
                  <div class="font-medium">#{{ $order->code }}</div>
                  <div class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y') }}</div>
                </div>
                <span class="px-2 py-1 rounded-full text-sm
                  @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                  @elseif($order->status == 'paid') bg-blue-100 text-blue-800
                  @elseif($order->status == 'processing') bg-indigo-100 text-indigo-800
                  @elseif($order->status == 'completed') bg-green-100 text-green-800
                  @elseif($order->status == 'canceled') bg-red-100 text-red-800
                  @endif">
                  @switch($order->status)
                    @case('pending') Chờ xác nhận @break
                    @case('paid') Đã thanh toán @break
                    @case('processing') Đang xử lý @break
                    @case('completed') Đã giao hàng @break
                    @case('canceled') Đã hủy @break
                    @default {{ $order->status }} @break
                  @endswitch
                </span>
              </div>
              <div class="mt-2 flex justify-between items-end">
                <div class="text-sm text-gray-600">{{ $order->items->count() }} sản phẩm</div>
                <div class="font-medium">{{ number_format($order->total) }}₫</div>
              </div>
            </div>
          </div>
        @endforeach
        
        <a href="{{ route('orders.index') }}" class="block text-center py-2 text-blue-600 hover:text-blue-800">
          Xem tất cả đơn hàng →
        </a>
      </div>
    @elseif(!auth()->check())
      <div class="bg-gray-50 rounded-lg p-6 text-center">
        <p class="text-gray-600 mb-4">Vui lòng đăng nhập để xem lịch sử đặt hàng</p>
        <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Đăng nhập
        </a>
      </div>
    @else
      <div class="bg-gray-50 rounded-lg p-6 text-center text-gray-600">
        Bạn chưa có đơn hàng nào
      </div>
    @endif
  </div>
  </div>
</div>

<script>
function showTab(tabName) {
    // Ẩn tất cả các tab
    document.getElementById('cart-tab').classList.add('hidden');
    document.getElementById('history-tab').classList.add('hidden');
    
    // Hiện tab được chọn
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Cập nhật style cho các nút tab
    document.querySelectorAll('.tab-button').forEach(button => {
        if (button.getAttribute('href') === '#' + tabName) {
            button.classList.remove('text-gray-500', 'border-transparent');
            button.classList.add('border-black', 'text-black');
        } else {
            button.classList.add('text-gray-500', 'border-transparent');
            button.classList.remove('border-black', 'text-black');
        }
    });

    // Ngăn chặn hành vi mặc định của thẻ a
    event.preventDefault();
}

// Kiểm tra hash URL khi tải trang
window.onload = function() {
    const hash = window.location.hash.substring(1); // Bỏ dấu # ở đầu
    if (hash === 'history') {
        showTab('history');
    } else {
        showTab('cart');
    }
}
</script>
@endsection
