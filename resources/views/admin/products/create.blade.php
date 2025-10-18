@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-4">Thêm sản phẩm</h1>
  <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" class="space-y-3">
    @csrf
    <input class="border p-2 w-full" name="name" placeholder="Tên">
    <input class="border p-2 w-full" name="sku" placeholder="SKU (tuỳ chọn)">
    <input class="border p-2 w-full" name="price" placeholder="Giá" type="number" step="0.01">
    <input class="border p-2 w-full" name="stock" placeholder="Tồn kho" type="number">
    <textarea class="border p-2 w-full" name="description" placeholder="Mô tả"></textarea>
    <input type="file" name="image" class="border p-2 w-full">
    <button class="px-3 py-2 bg-black text-white rounded">Lưu</button>
  </form>
</div>
@endsection
