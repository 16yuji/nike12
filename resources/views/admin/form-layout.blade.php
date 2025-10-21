@extends('admin.layout')

@section('title') @yield('form_title') @endsection

@section('content')
  <div class="max-w-3xl mx-auto">
    @if(session('ok'))
      <div class="p-3 mb-4 border bg-green-100">{{ session('ok') }}</div>
    @endif
    @if($errors->any())
      <div class="p-3 mb-4 border bg-red-100">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="bg-white border rounded-xl shadow-sm p-6">
      <h1 class="text-2xl font-semibold mb-4">@yield('form_heading')</h1>
      @yield('form_body')
    </div>
  </div>
@endsection
