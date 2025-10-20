@extends('admin.layout')
@section('title','Thêm người dùng')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Thêm người dùng</h1>

<form method="post" action="{{ route('admin.users.store') }}" class="space-y-3 max-w-xl">
  @csrf
  <div>
    <label class="block mb-1">Tên</label>
    <input name="name" value="{{ old('name') }}" class="border px-3 py-2 rounded w-full">
    @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" class="border px-3 py-2 rounded w-full">
    @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block mb-1">Mật khẩu</label>
    <input type="password" name="password" class="border px-3 py-2 rounded w-full">
    @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="block mb-1">Vai trò</label>
    <select name="role" class="border px-3 py-2 rounded w-full">
      <option value="customer" {{ old('role')==='customer'?'selected':'' }}>customer</option>
      <option value="admin" {{ old('role')==='admin'?'selected':'' }}>admin</option>
    </select>
    @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>
  <div class="space-x-2">
    <button class="px-4 py-2 bg-black text-white rounded">Lưu</button>
    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded">Hủy</a>
  </div>
</form>
@endsection
