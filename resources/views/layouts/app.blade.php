<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Hyunshop' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-zinc-900 antialiased">


  {{-- Thanh điều hướng phụ --}}
  <div class="w-full bg-zinc-100 text-xs">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <a href="#" class="hover:underline">Tìm cửa hàng</a>
        <a href="http://facebook.com/16yujiz/" target="_blank" class="hover:underline">Trợ giúp</a>
      </div>

      <div class="flex items-center gap-3">
        @guest
          <a href="{{ route('register') }}" class="hover:underline">Đăng ký</a>
          <a href="{{ route('login') }}" class="hover:underline">Đăng nhập</a>
        @else
          {{-- Chỉ hiển thị với tài khoản quản trị --}}
          @if(method_exists(auth()->user(),'isAdmin') && auth()->user()->isAdmin() && \Illuminate\Support\Facades\Route::has('admin.dashboard'))
            <a href="{{ route('admin.dashboard') }}" class="hover:underline font-semibold" title="Khu vực quản trị">Quản trị</a>
          @endif

           <a href="{{ route('account.show') }}" class="hover:underline">Tài khoản</a>

          {{-- Đăng xuất an toàn --}}
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="hover:underline" type="submit" aria-label="Đăng xuất">Đăng xuất</button>
          </form>
        @endguest
      </div>
    </div>
  </div>

  {{-- Header / Thanh điều hướng chính --}}
  <header class="border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-4">
      {{-- Logo --}}
      <a href="{{ route('home') }}" class="font-black tracking-tight text-2xl">
        Hyunshop
      </a>

      {{-- Menu chính --}}
      @php $gender = request('gender'); @endphp
      <nav class="hidden md:flex items-center gap-6 ml-6 text-[15px] font-medium">
        <a class="hover:underline {{ !$gender && request('category')==='new-featured' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'new-featured']) }}">Sản phẩm mới &amp; Nổi bật</a>
        <a class="hover:underline {{ $gender==='men' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['gender'=>'men']) }}">Nam</a>
        <a class="hover:underline {{ $gender==='women' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['gender'=>'women']) }}">Nữ</a>
        <a class="hover:underline {{ $gender==='kids' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['gender'=>'kids']) }}">Trẻ em</a>
        <a class="text-red-600 hover:underline {{ !$gender && request('category')==='sale' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'sale']) }}">Khuyến mãi</a>
      </nav>

      {{-- Ô tìm kiếm --}}
      <form action="{{ route('products.index') }}" method="GET" class="ml-auto flex w-full md:w-auto" role="search" aria-label="Tìm kiếm">
        <input name="q" value="{{ request('q') }}"
               class="w-full md:w-64 border border-zinc-300 rounded-l px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-zinc-400"
               placeholder="Tìm kiếm sản phẩm..."/>
        <button type="submit" class="border border-l-0 border-zinc-300 rounded-r px-3 text-sm">Tìm</button>
      </form>

      {{-- Các nút hành động --}}
      <div class="flex items-center gap-3">
        {{-- Nút Admin --}}
        @auth
          @if(method_exists(auth()->user(),'isAdmin') && auth()->user()->isAdmin() && \Illuminate\Support\Facades\Route::has('admin.dashboard'))
            <a href="{{ route('admin.dashboard') }}"
               class="hidden md:inline-flex items-center gap-1 text-sm px-2 py-1 border rounded hover:bg-zinc-50"
               title="Khu vực quản trị" aria-label="Khu vực quản trị">
              🛡️ <span>Quản trị</span>
            </a>
          @endif
        @endauth

        <a href="{{ route('cart.index') }}" class="text-xl" aria-label="Giỏ hàng">🛒</a>
      </div>
    </div>
  </header>

  {{-- Thông báo --}}
  @if(session('ok') || session('status'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
      <div class="rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
        {{ session('ok') ?? session('status') }}
      </div>
    </div>
  @endif
  @if($errors->any())
    <div class="max-w-7xl mx-auto px-4 mt-4">
      <div class="rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    </div>
  @endif

  {{-- Nội dung chính --}}
  <main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
  </main>

  {{-- Chân trang --}}
  <footer class="border-t">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm text-zinc-600">
      <div>
        <div class="font-semibold mb-2">Trợ giúp</div>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">Trạng thái đơn hàng</a></li>
          <li><a href="#" class="hover:underline">Giao hàng &amp; Đổi trả</a></li>
          <li><a href="mailto:huyy05@gmail.com?subject=Liên hệ hỗ trợ" class="hover:underline">Liên hệ hỗ trợ</a></li>
        </ul>
      </div>
      <div>
        <div class="font-semibold mb-2">Về chúng tôi</div>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">Giới thiệu</a></li>
          <li><a href="http://facebook.com/16yujiz/" target="_blank" class="hover:underline">Tuyển dụng</a></li>
        </ul>
      </div>
      <div>
        <div class="font-semibold mb-2">Danh mục</div>
        <ul class="space-y-1">
          <li><a href="{{ route('products.index',['gender'=>'men']) }}" class="hover:underline">Nam</a></li>
          <li><a href="{{ route('products.index',['gender'=>'women']) }}" class="hover:underline">Nữ</a></li>
          <li><a href="{{ route('products.index',['gender'=>'kids']) }}" class="hover:underline">Trẻ em</a></li>
        </ul>
      </div>
      <div class="text-zinc-500">
        © {{ date('Y') }} Hyunshop. Tất cả các quyền được bảo lưu.
      </div>
    </div>
  </footer>

</body>
</html>
