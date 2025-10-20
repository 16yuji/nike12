@extends('admin.layout')
@section('content')
<div class="max-w-6xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-3">Đơn hàng</h1>

  @if(session('ok')) <div class="p-2 bg-green-100 border my-2">{{ session('ok') }}</div> @endif

  <div class="overflow-x-auto">
    <table class="w-full border">
      <thead><tr class="bg-gray-100">
        <th class="p-2 border">ID</th>
        <th class="p-2 border">Khách</th>
        <th class="p-2 border">Tổng</th>
        <th class="p-2 border">Trạng thái</th>
        <th class="p-2 border">Ngày</th>
        <th class="p-2 border">Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($orders as $o)
        <tr>
          <td class="p-2 border">{{ $o->id }}</td>
          <td class="p-2 border">{{ optional($o->user)->name ?? 'N/A' }}</td>
          <td class="p-2 border">{{ number_format($o->total_amount ?? 0) }}</td>
          <td class="p-2 border">
            <form action="{{ route('admin.orders.updateStatus',$o) }}" method="post">
              @csrf @method('PATCH')
              <select name="status" class="border p-1">
                @foreach(['pending','paid','processing','completed','canceled'] as $st)
                  <option value="{{ $st }}" @selected($o->status===$st)>{{ $st }}</option>
                @endforeach
              </select>
              <button class="ml-2 px-2 py-1 border rounded">Lưu</button>
            </form>
          </td>
          <td class="p-2 border">{{ $o->created_at }}</td>
          <td class="p-2 border">
            <a class="underline" href="{{ route('admin.orders.show',$o) }}">Chi tiết</a>
            <form action="{{ route('admin.orders.destroy',$o) }}" method="post" class="inline" onsubmit="return confirm('Xóa đơn hàng?')">
              @csrf @method('DELETE')
              <button class="text-red-600 underline ml-2">Xóa</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
