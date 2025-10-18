@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-4">
  <h1 class="text-xl font-bold mb-4">Sửa người dùng #{{ $user->id }}</h1>
  <form action="{{ route('admin.users.update',$user) }}" method="post" class="space-y-3">
    @csrf @method('PUT')
    <input class="border p-2 w-full" name="name" value="{{ old('name',$user->name) }}" placeholder="Tên">
    <input class="border p-2 w-full" name="email" value="{{ old('email',$user->email) }}" type="email" placeholder="Email">
    <input class="border p-2 w-full" name="password" type="password" placeholder="Để trống nếu không đổi">
    <select class="border p-2 w-full" name="role">
      <option value="customer" @selected($user->role==='customer')>customer</option>
      <option value="admin" @selected($user->role==='admin')>admin</option>
    </select>
    <button class="px-3 py-2 bg-black text-white rounded">Cập nhật</button>
  </form>
</div>
@endsection
