@extends('layouts.app') {{-- hoặc layout bạn đang dùng --}}

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Tài khoản của tôi</h1>

    {{-- Thông báo trạng thái --}}
    @if (session('status'))
        <div class="mb-4 p-3 rounded border border-green-300 bg-green-50 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    {{-- Lỗi --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded border border-red-300 bg-red-50 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Cập nhật hồ sơ --}}
    <div class="bg-white rounded-xl shadow p-5 mb-8">
        <h2 class="text-lg font-medium mb-4">Thông tin hồ sơ</h2>
        <form method="POST" action="{{ route('account.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm mb-1">Họ và tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="pt-2">
                <button class="px-4 py-2 rounded bg-black text-white">Lưu thay đổi</button>
            </div>
        </form>
    </div>

    {{-- Đổi mật khẩu --}}
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-medium mb-4">Đổi mật khẩu</h2>
        <form method="POST" action="{{ route('account.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm mb-1">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm mb-1">Mật khẩu mới</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
                <p class="text-xs text-zinc-500 mt-1">Ít nhất 8 ký tự, gồm chữ và số.</p>
            </div>

            <div>
                <label class="block text-sm mb-1">Nhập lại mật khẩu mới</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>

            <div class="pt-2">
                <button class="px-4 py-2 rounded bg-black text-white">Cập nhật mật khẩu</button>
            </div>
        </form>
    </div>
</div>
@endsection
