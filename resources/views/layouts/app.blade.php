<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Nike-style Store' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-zinc-900 antialiased">

  {{-- Top notice bar --}}
  <div class="w-full bg-zinc-100 text-xs text-center py-2">
    
  </div>

  {{-- Slim top bar like nike.com/vn --}}
  <div class="w-full bg-zinc-100 text-xs">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <a href="#" class="hover:underline">Find a Store</a>
        <a href="#" class="hover:underline">Help</a>
      </div>
      <div class="flex items-center gap-4">
        @guest
          <a href="{{ route('register') }}" class="hover:underline">Join Us</a>
          <a href="{{ route('login') }}" class="hover:underline">Sign In</a>
        @else
          <a href="{{ url('/dashboard') }}" class="hover:underline">Account</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="hover:underline" type="submit">Sign Out</button>
          </form>
        @endguest
      </div>
    </div>
  </div>

  {{-- Header / Navigation --}}
  <header class="border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-4">
      {{-- Logo --}}
      <a href="{{ route('home') }}" class="font-black tracking-tight text-2xl">
        NIKE<span class="font-normal">.vn</span>
      </a>

      {{-- Primary nav --}}
      <nav class="hidden md:flex items-center gap-6 ml-6 text-[15px] font-medium">
        <a class="hover:underline {{ request('category')==='new-featured' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'new-featured']) }}">New &amp; Featured</a>
        <a class="hover:underline {{ request('category')==='men' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'men']) }}">Men</a>
        <a class="hover:underline {{ request('category')==='women' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'women']) }}">Women</a>
        <a class="hover:underline {{ request('category')==='kids' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'kids']) }}">Kids</a>
        <a class="text-red-600 hover:underline {{ request('category')==='sale' ? 'font-semibold' : '' }}"
           href="{{ route('products.index', ['category'=>'sale']) }}">Sale</a>
      </nav>

      {{-- Search (đưa về products.index) --}}
      <form action="{{ route('products.index') }}" method="GET" class="ml-auto flex w-full md:w-auto">
        <input name="q" value="{{ request('q') }}"
               class="w-full md:w-64 border border-zinc-300 rounded-l px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-zinc-400"
               placeholder="Search"/>
        <button type="submit" class="border border-l-0 border-zinc-300 rounded-r px-3 text-sm">Search</button>
      </form>

      {{-- Actions --}}
      <div class="flex items-center gap-3">
        <a href="{{ route('cart.index') }}" class="text-xl" aria-label="Cart">🛒</a>
      </div>
    </div>
  </header>

  <div class="w-full bg-zinc-100 text-xs text-center py-2">Free Standard Delivery &amp; 30-Day Free Returns.</div>

  {{-- Flash messages --}}
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

  {{-- Main content --}}
  <main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="border-t">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm text-zinc-600">
      <div>
        <div class="font-semibold mb-2">Trợ giúp</div>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">Trạng thái đơn hàng</a></li>
          <li><a href="#" class="hover:underline">Giao hàng & đổi trả</a></li>
          <li><a href="#" class="hover:underline">Liên hệ hỗ trợ</a></li>
        </ul>
      </div>
      <div>
        <div class="font-semibold mb-2">Về chúng tôi</div>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">Giới thiệu</a></li>
          <li><a href="#" class="hover:underline">Tuyển dụng</a></li>
        </ul>
      </div>
      <div>
        <div class="font-semibold mb-2">Danh mục</div>
        <ul class="space-y-1">
          <li><a href="{{ route('products.index',['category'=>'men']) }}" class="hover:underline">Men</a></li>
          <li><a href="{{ route('products.index',['category'=>'women']) }}" class="hover:underline">Women</a></li>
          <li><a href="{{ route('products.index',['category'=>'kids']) }}" class="hover:underline">Kids</a></li>
        </ul>
      </div>
      <div class="text-zinc-500">
        © {{ date('Y') }} Nike-style demo. Chỉ dùng cho học tập.
      </div>
    </div>
  </footer>

</body>
</html>
