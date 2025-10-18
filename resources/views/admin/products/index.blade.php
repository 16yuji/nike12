@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-bold">Sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="px-3 py-2 bg-black text-white rounded">+ Thêm</a>
  </div>

  <form class="my-3">
    <input type="text" name="q" value="{{ $q }}" placeholder="Tìm tên..." class="border p-2 rounded w-full md:w-80">
  </form>

  @if(session('ok')) <div class="p-2 bg-green-100 border my-2">{{ session('ok') }}</div> @endif

  <div class="overflow-x-auto">
    <table class="w-full border">
      <thead><tr class="bg-gray-100">
        <th class="p-2 border">ID</th>
        <th class="p-2 border">Tên</th>
        <th class="p-2 border">Giá</th>
        <th class="p-2 border">Kho</th>
        <th class="p-2 border">Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($products as $p)
        <tr>
          <td class="p-2 border">{{ $p->id }}</td>
          <td class="p-2 border">{{ $p->name }}</td>
          <td class="p-2 border">{{ number_format($p->price) }}</td>
          <td class="p-2 border">{{ $p->stock }}</td>
          <td class="p-2 border">
            <a class="underline" href="{{ route('admin.products.edit',$p) }}">Sửa</a>
            <form action="{{ route('admin.products.destroy',$p) }}" method="post" class="inline"
                  onsubmit="return confirm('Xóa sản phẩm?')">
              @csrf @method('DELETE')
              <button class="text-red-600 underline ml-2">Xóa</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $products->links() }}</div>
</div>
@endsection
