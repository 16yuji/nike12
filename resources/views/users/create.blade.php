@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-4">Thêm người dùng</h1>
  <form action="{{ route('admin.users.store') }}" method="post" class="space-y-3">
    @csrf
    <input class="border p-2 w-full" name="name" placeholder="Tên">
    <input class="border p-2 w-full" name="email" type="email" placeholder="Email">
    <input class="border p-2 w-full" name="password" type="password" placeholder="Mật khẩu">
    <select class="border p-2 w-full" name="role">
      <option value="customer">customer</option>
      <option value="admin">admin</option>
    </select>
    <button class="px-3 py-2 bg-black text-white rounded">Lưu</button>
  </form>
</div>
@endsection
