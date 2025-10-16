<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, ProductImage};

class ProductAdminController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('admin.products.create');
    }

    public function store(Request $r)
    {
        $this->authorize('admin');
        $data = $r->validate([
            'name'=>'required','slug'=>'required|unique:products,slug',
            'sku'=>'required|unique:products,sku',
            'price'=>'required|integer','sale_price'=>'nullable|integer',
            'category_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'image'=>'nullable|image'
        ]);
        $p = Product::create($data);
        if ($r->file('image')){
            $path = $r->file('image')->store('products','public');
            $p->images()->create(['path'=>$path,'is_main'=>true,'sort_order'=>1]);
        }
        return redirect()->route('admin.products.index')->with('ok','Đã tạo!');
    }
}
