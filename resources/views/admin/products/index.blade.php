@extends('admin.layout')
@section('title','Quản lý Sản phẩm')
@section('page-title','Quản lý Sản phẩm')

@section('content')
  <a href="{{ route('admin.products.create') }}" class="btn btn-green mb-3">+ Thêm sản phẩm</a>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>Ảnh</th><th>Tên</th><th>Giá</th><th>Mô tả</th><th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td><img src="{{ $p->thumbnail_url }}" alt="" style="width:120px;height:auto"></td>
          <td>{{ $p->name }}</td>
          <td>{{ number_format($p->price,0,',','.') }} VND</td>
          <td>{{ $p->description }}</td>
          <td class="space-x-1">
            <a href="{{ route('admin.products.show',$p) }}" class="btn btn-blue">Xem</a>
            <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-yellow">Sửa</a>
            <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button class="btn btn-red" onclick="return confirm('Xóa?')">Xóa</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">Chưa có sản phẩm</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $products->links() ?? '' }}
@endsection