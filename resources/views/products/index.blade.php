@extends('layouts.app')

@section('content')
@php
    $title = match(request('gender')) {
        'men' => 'Sản phẩm Nam',
        'women' => 'Sản phẩm Nữ',
        'kids' => 'Sản phẩm Trẻ em',
        default => 'Tất cả sản phẩm'
    };
@endphp

<h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
  @foreach($products as $p)
  <a href="{{ route('products.show',$p->slug) }}" class="group">
    <div class="aspect-square bg-gray-100 overflow-hidden">
      <img
        class="w-full h-full object-cover group-hover:scale-105 transition"
        src="{{ $p->image_url }}"
        alt="{{ $p->name }}"
        loading="lazy"
      >
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
