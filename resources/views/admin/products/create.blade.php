@extends('admin.form-layout')

@section('form_title','Thêm sản phẩm')
@section('form_heading','Thêm sản phẩm')

@section('form_body')
<form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
  @csrf
  @include('admin.products._form')
</form>
@endsection
