<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $r)
    {
        $q = Product::query()
            ->with(['mainImage','brand','category'])
            ->where('is_active', true);

        // Lọc theo type (nam/nữ/trẻ em)
        if ($gender = $r->get('gender')) {
            $q->where('type', $gender);
        }
        
        // Lọc theo category - bỏ qua nếu là "new-featured"
        if ($category = $r->get('category')) {
            if ($category !== 'new-featured') {
                $q->whereHas('category', fn($c) => $c->where('slug', $category));
            }
        }

        if ($brand = $r->get('brand')) {
            $q->whereHas('brand', fn($b) => $b->where('slug', $brand));
        }
        if ($color = $r->get('color')) {
            $q->whereHas('variants', fn($v) => $v->where('color', $color));
        }
        if ($size = $r->get('size')) {
            $q->whereHas('variants', fn($v) => $v->where('size', $size));
        }

        // Search theo tên + SKU
        if ($term = trim((string) $r->get('q'))) {
            $q->where(function ($qq) use ($term) {
                $qq->where('name', 'like', "%{$term}%")
                   ->orWhere('sku', 'like', "%{$term}%");
            });
        }

        // Lọc giá theo giá hiệu lực (sale_price nếu có, ngược lại price)
        if (is_numeric($r->get('min'))) {
            $q->whereRaw('COALESCE(sale_price, price) >= ?', [(int) $r->get('min')]);
        }
        if (is_numeric($r->get('max'))) {
            $q->whereRaw('COALESCE(sale_price, price) <= ?', [(int) $r->get('max')]);
        }

        // Sort an toàn
        $sort = $r->get('sort');
        $sort = in_array($sort, ['price_asc','price_desc','newest','popular'], true) ? $sort : 'newest';

        switch ($sort) {
            case 'price_asc':
                $q->orderByRaw('COALESCE(sale_price, price) asc');
                break;
            case 'price_desc':
                $q->orderByRaw('COALESCE(sale_price, price) desc');
                break;
            case 'popular':
                // placeholder: khi có bảng thống kê, thay bằng order theo lượt bán/xem
                $q->orderByDesc('id');
                break;
            default: // newest
                $q->latest();
        }

        $products = $q->paginate(24)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load(['images','variants','brand','category']);
        return view('products.show', compact('product'));
    }
}

