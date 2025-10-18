@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto p-4">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-bold">Người dùng</h1>
    <a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-black text-white rounded">+ Thêm</a>
  </div>

  <form class="my-3">
    <input type="text" name="q" value="{{ $q }}" placeholder="Tìm tên/email..." class="border p-2 rounded w-full md:w-80">
  </form>

  @if(session('ok')) <div class="p-2 bg-green-100 border my-2">{{ session('ok') }}</div> @endif

  <div class="overflow-x-auto">
    <table class="w-full border">
      <thead><tr class="bg-gray-100">
        <th class="p-2 border">ID</th>
        <th class="p-2 border">Tên</th>
        <th class="p-2 border">Email</th>
        <th class="p-2 border">Role</th>
        <th class="p-2 border">Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($users as $u)
        <tr>
          <td class="p-2 border">{{ $u->id }}</td>
          <td class="p-2 border">{{ $u->name }}</td>
          <td class="p-2 border">{{ $u->email }}</td>
          <td class="p-2 border">{{ $u->role }}</td>
          <td class="p-2 border">
            <a class="underline" href="{{ route('admin.users.edit',$u) }}">Sửa</a>
            @if(auth()->id() !== $u->id)
            <form action="{{ route('admin.users.destroy',$u) }}" method="post" class="inline" onsubmit="return confirm('Xóa người dùng?')">
              @csrf @method('DELETE')
              <button class="text-red-600 underline ml-2">Xóa</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $users->links() }}</div>
</div>
@endsection
