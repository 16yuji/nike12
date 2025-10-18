@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
  <h1 class="text-2xl font-bold mb-4">Bảng điều khiển Admin</h1>
  <div class="grid md:grid-cols-3 gap-4">
    <a href="{{ route('admin.products.index') }}" class="p-4 border rounded">Quản lý Sản phẩm</a>
    <a href="{{ route('admin.orders.index') }}" class="p-4 border rounded">Quản lý Đơn hàng</a>
    <a href="{{ route('admin.users.index') }}" class="p-4 border rounded">Quản lý Người dùng</a>
  </div>
</div>
@endsection
