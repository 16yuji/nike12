@extends('layouts.app')
@section('content')
<article class="grid grid-cols-1 md:grid-cols-2 gap-8">
  <div>
    <div class="aspect-square bg-gray-100 overflow-hidden rounded">
      <img class="w-full h-full object-cover" src="{{ $product->mainImage?->path ? asset('storage/'.$product->mainImage->path) : 'https://placehold.co/800x800' }}">
    </div>
    <div class="grid grid-cols-4 gap-2 mt-2">
      @foreach($product->images as $img)
        <img class="border rounded" src="{{ asset('storage/'.$img->path) }}">
      @endforeach
    </div>
  </div>
  <div>
    <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
    <div class="mt-2 text-zinc-600">{{ $product->brand?->name }}</div>
    <div class="mt-2">
      @if($product->sale_price)
        <span class="text-2xl font-bold">{{ number_format($product->sale_price) }}₫</span>
        <span class="line-through text-zinc-400 ml-3">{{ number_format($product->price) }}₫</span>
      @else
        <span class="text-2xl font-bold">{{ number_format($product->price) }}₫</span>
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
    <div class="mt-6 prose max-w-none">{{ $product->description }}</div>
  </div>
</article>
@endsection
