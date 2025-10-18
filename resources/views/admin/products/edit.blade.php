@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-4">Sửa sản phẩm #{{ $product->id }}</h1>
  <form action="{{ route('admin.products.update',$product) }}" method="post" enctype="multipart/form-data" class="space-y-3">
    @csrf @method('PUT')
    <input class="border p-2 w-full" name="name" value="{{ old('name',$product->name) }}" placeholder="Tên">
    <input class="border p-2 w-full" name="sku" value="{{ old('sku',$product->sku) }}" placeholder="SKU">
    <input class="border p-2 w-full" name="price" value="{{ old('price',$product->price) }}" type="number" step="0.01">
    <input class="border p-2 w-full" name="stock" value="{{ old('stock',$product->stock) }}" type="number">
    <textarea class="border p-2 w-full" name="description" placeholder="Mô tả">{{ old('description',$product->description) }}</textarea>
    <input type="file" name="image" class="border p-2 w-full">
    @if($product->image_path)
      <img src="{{ asset('storage/'.$product->image_path) }}" class="w-32 border" />
    @endif
    <button class="px-3 py-2 bg-black text-white rounded">Cập nhật</button>
  </form>
</div>
@endsection
