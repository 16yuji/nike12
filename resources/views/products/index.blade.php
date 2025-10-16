@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Sản phẩm</h1>
<form method="GET" class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-6">
  <input class="border px-3 py-2" type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm...">
  <input class="border px-3 py-2" type="number" name="min" value="{{ request('min') }}" placeholder="Giá từ">
  <input class="border px-3 py-2" type="number" name="max" value="{{ request('max') }}" placeholder="Giá đến">
  <select class="border px-3 py-2" name="color">
    <option value="">Màu</option><option @selected(request('color')=='Black')>Black</option>
  </select>
  <select class="border px-3 py-2" name="size">
    <option value="">Size</option><option @selected(request('size')=='42')>42</option>
  </select>
  <select class="border px-3 py-2" name="sort">
    <option value="newest">Mới nhất</option>
    <option value="price_asc" @selected(request('sort')=='price_asc')>Giá ↑</option>
    <option value="price_desc" @selected(request('sort')=='price_desc')>Giá ↓</option>
  </select>
</form>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
  @foreach($products as $p)
  <a href="{{ route('products.show',$p->slug) }}" class="group">
    <div class="aspect-square bg-gray-100 overflow-hidden">
      <img class="w-full h-full object-cover group-hover:scale-105 transition"
           src="{{ $p->mainImage?->path ? asset('storage/'.$p->mainImage->path) : 'https://placehold.co/600x600' }}">
    </div>
    <div class="mt-2">
      <div class="text-sm text-gray-600">{{ $p->brand?->name }}</div>
      <div class="font-medium">{{ $p->name }}</div>
      <div class="mt-1">
        @if($p->sale_price)
          <span class="font-semibold">{{ number_format($p->sale_price) }}₫</span>
          <span class="line-through text-gray-400 ml-2">{{ number_format($p->price) }}₫</span>
        @else
          <span class="font-semibold">{{ number_format($p->price) }}₫</span>
        @endif
      </div>
    </div>
  </a>
  @endforeach
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
