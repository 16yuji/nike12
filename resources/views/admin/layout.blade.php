
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Admin Dashboard')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    .admin-shell {min-height:100vh; display:grid; grid-template-columns: 260px 1fr;}
    .admin-sidebar {background:#3f445d; color:#fff;}
    .admin-sidebar a {display:block; padding:12px 16px; color:#e5e7eb; text-decoration:none;}
    .admin-sidebar a.active, .admin-sidebar a:hover {background:#2f344a; color:#fff;}
    .admin-topbar {background:#171a2b; color:#fff; padding:14px 20px; display:flex; align-items:center; justify-content:space-between;}
    .admin-content {background:#f3f4f6; padding:24px;}
    .badge {padding:6px 10px; border-radius:6px; font-weight:600;}
    .btn {padding:6px 12px; border-radius:6px; text-decoration:none; display:inline-block;}
    .btn-blue{background:#3b82f6;color:#fff}
    .btn-yellow{background:#f59e0b;color:#111827}
    .btn-red{background:#ef4444;color:#fff}
    .btn-green{background:#22c55e;color:#fff}
    table {width:100%; background:#fff; border-collapse:collapse;}
    th,td {border:1px solid #e5e7eb; padding:10px; vertical-align:top;}
  </style>
</head>
<body class="antialiased">

  <div class="admin-topbar">
    <div class="text-xl font-bold">Admin Dashboard</div>
    <div class="flex items-center gap-3">
      <span>Xin chào, {{ optional(auth()->user())->name ?? 'Admin' }} (admin)</span>

      {{-- Chỉ hiện link Profile nếu route tồn tại; nếu không thì fallback --}}
      @php use Illuminate\Support\Facades\Route as R; @endphp
      @if (R::has('profile.edit'))
        <a href="{{ route('profile.edit') }}" class="btn">Profile</a>
      @elseif (R::has('dashboard'))
        <a href="{{ route('dashboard') }}" class="btn">Profile</a>
      @else
        <a href="{{ url('/dashboard') }}" class="btn">Profile</a>
      @endif

      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="btn btn-red" type="submit">Đăng xuất</button>
      </form>
    </div>
  </div>

  <div class="admin-shell">
    <aside class="admin-sidebar">
      @php
        $is = fn($pat) => request()->routeIs($pat) ? 'active' : '';
      @endphp

      <a class="{{ $is('admin.orders.*') }}" href="{{ route('admin.orders.index') }}">Quản lý Đơn hàng</a>
      <a class="{{ $is('admin.products.*') }}" href="{{ route('admin.products.index') }}">Quản lý Sản phẩm</a>
      <a class="{{ $is('admin.users.*') }}" href="{{ route('admin.users.index') }}">Quản lý Người dùng</a>
    </aside>

    <main class="admin-content">
      <h1 class="text-2xl font-bold mb-4">@yield('page-title')</h1>

      {{-- Flash & errors (tùy chọn) --}}
      @if(session('ok') || session('status'))
        <div class="rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm mb-4">
          {{ session('ok') ?? session('status') }}
        </div>
      @endif
      @if($errors->any())
        <div class="rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm mb-4">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

</body>
</html>

