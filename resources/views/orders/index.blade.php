@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Đơn hàng của tôi</h1>
@if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->count())
  <div class="space-y-4">
  @foreach($orders as $o)
    <div class="border rounded p-4">
      <div class="flex items-center justify-between">
        <div>Mã: <span class="font-mono">{{ $o->code }}</span></div>
        <div class="text-sm text-zinc-600">{{ $o->status }}</div>
      </div>
      <div class="mt-2 text-sm">Tổng: <strong>{{ number_format($o->total) }}₫</strong></div>
    </div>
  @endforeach
  </div>
  <div class="mt-4">{{ $orders->links() }}</div>
@else
  <p>Chưa có đơn hàng.</p>
@endif
@endsection
