@extends('admin.layout')
@section('content')
<div class="max-w-6xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-3">Đơn hàng</h1>

  @if(session('ok')) <div class="p-2 bg-green-100 border my-2">{{ session('ok') }}</div> @endif

  <div class="mb-4 flex gap-2">
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded {{ !$status ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
      Tất cả
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded {{ $status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100' }}">
      Chờ xác nhận
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="px-4 py-2 rounded {{ $status === 'paid' ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
      Đã thanh toán
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded {{ $status === 'processing' ? 'bg-indigo-500 text-white' : 'bg-gray-100' }}">
      Đang xử lý
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded {{ $status === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-100' }}">
      Đã giao hàng
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'canceled']) }}" class="px-4 py-2 rounded {{ $status === 'canceled' ? 'bg-red-500 text-white' : 'bg-gray-100' }}">
      Đã hủy
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full border">
      <thead><tr class="bg-gray-100">
        <th class="p-2 border">Mã đơn hàng</th>
        <th class="p-2 border">Khách hàng</th>
        <th class="p-2 border">Người nhận</th>
        <th class="p-2 border">Tổng tiền</th>
        <th class="p-2 border">Trạng thái</th>
        <th class="p-2 border">Ngày đặt</th>
        <th class="p-2 border"></th>
      </tr></thead>
      <tbody>
        @foreach($orders as $o)
        <tr class="hover:bg-gray-50">
          <td class="p-2 border font-medium">{{ $o->code }}</td>
          <td class="p-2 border">
            <div>{{ optional($o->user)->name ?? 'N/A' }}</div>
            <div class="text-sm text-gray-500">{{ optional($o->user)->email }}</div>
          </td>
          <td class="p-2 border">
            <div>{{ $o->shipping_name }}</div>
            <div class="text-sm text-gray-500">{{ $o->shipping_phone }}</div>
          </td>
          <td class="p-2 border text-right font-medium">{{ number_format($o->total) }}₫</td>
          <td class="p-2 border">
            <form action="{{ route('admin.orders.updateStatus', $o) }}" method="POST" class="flex items-center gap-2">
              @csrf
              @method('PATCH')
              <select name="status" class="border rounded px-2 py-1">
                <option value="pending" {{ $o->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="paid" {{ $o->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="processing" {{ $o->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                <option value="completed" {{ $o->status == 'completed' ? 'selected' : '' }}>Đã giao hàng</option>
                <option value="canceled" {{ $o->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
              </select>
              <button type="submit" class="px-3 py-1 rounded text-white text-sm
                @if($o->status == 'pending') bg-yellow-500 hover:bg-yellow-600
                @elseif($o->status == 'paid') bg-blue-500 hover:bg-blue-600
                @elseif($o->status == 'processing') bg-indigo-500 hover:bg-indigo-600
                @elseif($o->status == 'completed') bg-green-500 hover:bg-green-600
                @elseif($o->status == 'canceled') bg-red-500 hover:bg-red-600
                @endif">
                Cập nhật
              </button>
            </form>
          </td>
          <td class="p-2 border whitespace-nowrap text-gray-500">
            {{ $o->created_at->format('d/m/Y H:i') }}
          </td>
          <td class="p-2 border text-center">
            <a href="{{ route('admin.orders.show', $o) }}" class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
