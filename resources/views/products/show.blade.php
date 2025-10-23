@extends('layouts.app')

@section('content')
@php
    // Lấy ảnh cover ưu tiên:
    // 1) cột products.image_path
    // 2) quan hệ $product->mainImage->path
    $coverPath = $product->image_path ?? optional($product->mainImage)->path;
    $coverUrl  = $coverPath ? asset('storage/'.$coverPath) : 'https://placehold.co/800x800';

    // Bộ sưu tập ảnh phụ (nếu có)
    $gallery = $product->images ?? collect();
@endphp

<article class="grid grid-cols-1 md:grid-cols-2 gap-8">
  <div>
    <div class="aspect-square bg-gray-100 overflow-hidden rounded">
      <img
        class="w-full h-full object-cover"
        src="{{ $coverUrl }}"
        alt="{{ $product->name }}"
        loading="lazy">
    </div>

    <div class="grid grid-cols-4 gap-2 mt-2">
      @forelse($gallery as $img)
        @php
            $thumbUrl = !empty($img->path) ? asset('storage/'.$img->path) : $coverUrl;
        @endphp
        <img class="border rounded w-full h-full object-cover"
             src="{{ $thumbUrl }}"
             alt="{{ $product->name }} thumbnail"
             loading="lazy">
      @empty
        {{-- Không có ảnh phụ thì ẩn lưới hoặc hiện 1 thumbnail cover --}}
        {{-- <img class="border rounded" src="{{ $coverUrl }}" alt="{{ $product->name }} thumbnail" loading="lazy"> --}}
      @endforelse
    </div>
  </div>

  <div>
    <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
    <div class="mt-2 text-zinc-600">{{ $product->brand?->name }}</div>

    <div class="mt-2">
      @if($product->sale_price)
        <span class="text-2xl font-bold">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
        <span class="line-through text-zinc-400 ml-3">{{ number_format($product->price, 0, ',', '.') }}₫</span>
      @else
        <span class="text-2xl font-bold">{{ number_format($product->price, 0, ',', '.') }}₫</span>
      @endif
    </div>

    <form method="POST" action="{{ route('cart.add') }}" class="mt-6">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">

      <label class="block text-sm">Size</label>
      <select class="border px-3 py-2 mt-1" name="variant_id">
        <option value="">Không chọn</option>
        @foreach($product->variants as $v)
          <option value="{{ $v->id }}">{{ $v->size }} - {{ $v->color }}</option>
        @endforeach
      </select>

      <div class="mt-4 flex items-center gap-3">
        <label>Số lượng</label>
        <input type="number" class="border px-3 py-2 w-24" name="qty" value="1" min="1">
      </div>

      <button class="mt-6 rounded-md bg-black text-white px-4 py-2">Thêm vào giỏ</button>
    </form>

    <div class="mt-6 prose max-w-none">
      {{ $product->description }}
    </div>
  </div>
</article>
@endsection
