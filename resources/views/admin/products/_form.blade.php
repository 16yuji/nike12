@php
  $isEdit = isset($product);
@endphp

<div class="space-y-4">
  <div>
    <label class="block mb-1">Tên sản phẩm</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="border px-3 py-2 rounded w-full">
    @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block mb-1">SKU</label>
      <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="border px-3 py-2 rounded w-full">
      @error('sku')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="block mb-1">Giá (VND)</label>
      <input type="number" min="0" step="1" name="price" value="{{ old('price', $product->price ?? '') }}" class="border px-3 py-2 rounded w-full">
      @error('price')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block mb-1">Giá giảm (sale_price)</label>
      <input type="number" min="0" step="1" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" class="border px-3 py-2 rounded w-full">
      @error('sale_price')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="inline-flex items-center gap-2 mt-7">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
        <span>Đang bán (is_active)</span>
      </label>
      @error('is_active')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block mb-1">Danh mục (category_id)</label>
      <input type="number" name="category_id" value="{{ old('category_id', $product->category_id ?? '') }}" class="border px-3 py-2 rounded w-full">
      @error('category_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="block mb-1">Thương hiệu (brand_id)</label>
      <input type="number" name="brand_id" value="{{ old('brand_id', $product->brand_id ?? '') }}" class="border px-3 py-2 rounded w-full">
      @error('brand_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="block mb-1">Loại sản phẩm</label>
      <select name="type" class="border px-3 py-2 rounded w-full">
        <option value="">-- Chọn loại --</option>
        <option value="men" {{ old('type', $product->type ?? '') == 'men' ? 'selected' : '' }}>Nam</option>
        <option value="women" {{ old('type', $product->type ?? '') == 'women' ? 'selected' : '' }}>Nữ</option>
        <option value="kids" {{ old('type', $product->type ?? '') == 'kids' ? 'selected' : '' }}>Trẻ em</option>
      </select>
      @error('type')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
  </div>

  <div>
    <label class="block mb-1">Mô tả</label>
    <textarea name="description" rows="4" class="border px-3 py-2 rounded w-full">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block mb-1">Ảnh đại diện</label>
    <input type="file" name="image" accept="image/*" class="border px-3 py-2 rounded w-full">
    @error('image')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror

    @if(($product->image_path ?? null))
      <div class="mt-2">
        <img src="{{ Storage::disk('public')->url($product->image_path) }}" class="max-h-40 rounded border">
      </div>
    @endif
  </div>

  <div class="flex gap-3 pt-2">
    <button class="px-4 py-2 bg-black text-white rounded">{{ $isEdit ? 'Cập nhật' : 'Tạo mới' }}</button>
    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded">Hủy</a>
  </div>
</div>

