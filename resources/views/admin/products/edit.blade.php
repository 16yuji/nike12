@extends('admin.form-layout')

@section('form_title','Sửa sản phẩm')
@section('form_heading','Sửa sản phẩm')

@section('form_body')
<form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
  @csrf @method('PUT')
  @include('admin.products._form', ['product' => $product])
</form>
@endsection

