@extends('admin.layout')

@section('title','Quản lý người dùng')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-semibold">Người dùng</h1>
  <a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-black text-white rounded">+ Thêm người dùng</a>
</div>

@if(session('ok'))
  <div class="p-3 bg-green-100 border mb-3">{{ session('ok') }}</div>
@endif
@if($errors->any())
  <div class="p-3 bg-red-100 border mb-3">
    <ul class="list-disc pl-5">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form method="get" class="mb-3">
  <input type="text" name="q" value="{{ $q }}" placeholder="Tìm theo tên/email..." class="border px-3 py-2 rounded w-64">
  <button class="px-3 py-2 border rounded">Tìm</button>
</form>

<table class="min-w-full border">
  <thead class="bg-gray-50">
    <tr>
      <th class="p-2 border">ID</th>
      <th class="p-2 border">Tên</th>
      <th class="p-2 border">Email</th>
      <th class="p-2 border">Vai trò</th>
      <th class="p-2 border">Thao tác</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $u)
    <tr>
      <td class="p-2 border">{{ $u->id }}</td>
      <td class="p-2 border">{{ $u->name }}</td>
      <td class="p-2 border">{{ $u->email }}</td>
      <td class="p-2 border">{{ $u->role }}</td>
      <td class="p-2 border space-x-2">
        <a href="{{ route('admin.users.edit',$u) }}" class="px-2 py-1 border rounded">Sửa</a>
        <form action="{{ route('admin.users.destroy',$u) }}" method="post" class="inline-block" onsubmit="return confirm('Xóa người dùng này?')">
          @csrf @method('DELETE')
          <button class="px-2 py-1 border rounded">Xóa</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
