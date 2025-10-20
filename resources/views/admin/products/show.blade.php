@extends('admin.layout')
@section('title','Chi tiết sản phẩm')
@section('content')
<h1 class="text-2xl font-semibold mb-4">{{ $product->name }}</h1>
<p>SKU: {{ $product->sku }}</p>
<p>Giá: {{ number_format($product->price,0,',','.') }} đ</p>
<p>Tồn kho: {{ $product->stock }}</p>
@if($product->image_path)
  <img src="{{ Storage::disk('public')->url($product->image_path) }}" class="max-w-xs mt-2">
@endif
<div class="mt-4">
  <a href="{{ route('admin.products.edit',$product) }}" class="px-3 py-2 border rounded">Sửa</a>
  <a href="{{ route('admin.products.index') }}" class="px-3 py-2 border rounded">Về danh sách</a>
</div>
@endsection
