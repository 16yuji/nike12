<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $products = Product::when($q, fn($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        // View giao diện admin
        return view('admin.products.index', compact('products', 'q'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    // app/Http/Controllers/Admin/ProductAdminController.php

public function store(Request $request)
{
    $data = $request->validate([
        'name'        => ['required','string','max:255', Rule::unique('products','name')],
        'sku'         => ['nullable','string','max:100', Rule::unique('products','sku')],
        'price'       => ['required','numeric','min:0'],
        'stock'       => ['required','integer','min:0'],
        'description' => ['nullable','string'],
        'image'       => ['nullable','image','max:2048'],
        'category_id' => ['nullable','integer'],
    ]);

    // 🔧 Chuẩn hoá: rỗng -> null
    $data['category_id'] = filled($data['category_id'] ?? null) ? (int) $data['category_id'] : null;

    if ($request->hasFile('image')) {
        $data['image_path'] = $request->file('image')->store('products', 'public');
    }

    Product::create($data);
    return redirect()->route('admin.products.index')->with('ok', 'Đã tạo sản phẩm.');
}

public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'name'        => ['required','string','max:255', Rule::unique('products','name')->ignore($product->id)],
        'sku'         => ['nullable','string','max:100', Rule::unique('products','sku')->ignore($product->id)],
        'price'       => ['required','numeric','min:0'],
        'stock'       => ['required','integer','min:0'],
        'description' => ['nullable','string'],
        'image'       => ['nullable','image','max:2048'],
        'category_id' => ['nullable','integer'],
    ]);

    // 🔧 Chuẩn hoá: rỗng -> null
    $data['category_id'] = filled($data['category_id'] ?? null) ? (int) $data['category_id'] : null;

    if ($request->hasFile('image')) {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $data['image_path'] = $request->file('image')->store('products', 'public');
    }

    $product->update($data);
    return redirect()->route('admin.products.index')->with('ok', 'Đã cập nhật sản phẩm.');
}


    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return back()->with('ok', 'Đã xóa sản phẩm.');
    }

    // (tuỳ chọn) show chi tiết trong khu vực admin
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }
}
