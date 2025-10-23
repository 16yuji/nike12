<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema; // để kiểm tra cột có trong DB không

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();

        $products = Product::when($q, function ($qr) use ($q) {
                $qr->where('name', 'like', "%{$q}%")
                   ->orWhere('sku', 'like', "%{$q}%");
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products','q'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    // === store() merged: validate + upload ảnh với Storage public/products ===
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255', Rule::unique('products','name')],
            'sku'         => ['nullable','string','max:100', Rule::unique('products','sku')],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['nullable','integer','min:0'],              // sẽ tự bỏ nếu DB không có
            'description' => ['nullable','string'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'brand_id'    => ['nullable','integer','exists:brands,id'],
            'type'        => ['nullable','string'],
            'is_active'   => ['nullable','boolean'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'], // quan trọng
        ]);

        // Tạo slug duy nhất từ name
        $data['slug'] = $this->uniqueSlug($data['name']);

        // Lưu ảnh vào disk "public" => storage/app/public/products
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        // Chỉ giữ lại các cột thực sự tồn tại để tránh lỗi 1054
        $data = $this->filterColumnsForProducts($data);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('ok','Đã thêm sản phẩm');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // === update() merged: validate + xóa ảnh cũ (nếu có) + upload ảnh mới ===
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255', Rule::unique('products','name')->ignore($product->id)],
            'sku'         => ['nullable','string','max:100', Rule::unique('products','sku')->ignore($product->id)],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['nullable','integer','min:0'],
            'description' => ['nullable','string'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'brand_id'    => ['nullable','integer','exists:brands,id'],
            'type'        => ['nullable','string'],
            'is_active'   => ['nullable','boolean'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        // Cập nhật slug nếu đổi tên
        if ($product->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }

        // Nếu có ảnh mới: xóa ảnh cũ (nếu tồn tại) rồi lưu ảnh mới
        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path); // <— đã sửa dấu nháy thừa
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        // Chỉ giữ các cột đang có trong DB
        $data = $this->filterColumnsForProducts($data);

        $product->update($data);

        return back()->with('ok','Đã cập nhật');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return back()->with('ok','Đã xoá sản phẩm.');
    }

    /** Tạo slug duy nhất (tự cộng hậu tố -2, -3 ... nếu trùng) */
    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn($q)=>$q->where('id','<>',$ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /** Chỉ giữ các key trùng cột thực sự tồn tại trong bảng 'products' */
    protected function filterColumnsForProducts(array $data): array
    {
        $columns = Schema::getColumnListing('products');
        return array_filter(
            $data,
            fn($v, $k) => in_array($k, $columns, true),
            ARRAY_FILTER_USE_BOTH
        );
    }
}
