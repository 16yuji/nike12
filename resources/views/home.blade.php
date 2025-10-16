@extends('layouts.app')
@section('content')
  <div class="py-6">
    <h1 class="text-2xl font-semibold mb-2">Chào mừng đến Nike12</h1>
    <p class="text-zinc-600">Bắt đầu khám phá danh mục sản phẩm.</p>
    <div class="mt-6">
      <a href="{{ route('products.index') }}" class="inline-block rounded-md bg-black text-white px-4 py-2">Xem Sản phẩm</a>
    </div>
  </div>
@endsection
