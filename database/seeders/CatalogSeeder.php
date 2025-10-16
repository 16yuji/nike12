<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Category,Brand,Product,ProductVariant,ProductImage};

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $men = Category::create(['name'=>'Men','slug'=>'men']);
        $women = Category::create(['name'=>'Women','slug'=>'women']);
        $shoes = Category::create(['name'=>'Shoes','slug'=>'shoes','parent_id'=>$men->id]);

        $nike = Brand::create(['name'=>'Nike','slug'=>'nike']);
        $pegasus = Product::create([
            'category_id'=>$shoes->id,'brand_id'=>$nike->id,
            'name'=>'Pegasus Premium','slug'=>'pegasus-premium',
            'sku'=>'PEGA-001','price'=>3999000,'sale_price'=>3499000,'is_active'=>1
        ]);
        ProductVariant::create(['product_id'=>$pegasus->id,'color'=>'Black','size'=>'42','sku'=>'PEGA-001-B-42','stock'=>10]);
        ProductImage::create(['product_id'=>$pegasus->id,'path'=>'products/pegasus.jpg','is_main'=>true,'sort_order'=>1]);
    }
}
