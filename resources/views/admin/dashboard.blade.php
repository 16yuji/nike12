@extends('admin.layout')
@section('title','Admin Dashboard')
@section('page-title','Tổng quan')
@section('content')
  <div class="grid gap-4 md:grid-cols-3">
    <div class="p-4 bg-white rounded-xl shadow">Tổng đơn hôm nay: <strong>{{ $ordersToday ?? 0 }}</strong></div>
    <div class="p-4 bg-white rounded-xl shadow">Sản phẩm: <strong>{{ $productCount ?? 0 }}</strong></div>
    <div class="p-4 bg-white rounded-xl shadow">Người dùng: <strong>{{ $userCount ?? 0 }}</strong></div>
  </div>
@endsection