<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','sku','price','stock','description',
        'image_path','category_id','type','meta','brand_id','is_active'
    ];

    protected $casts = [
        'meta' => 'array',
        'is_active' => 'boolean',
    ];

    // (Tuỳ chọn) Nếu muốn khi toArray()/toJson() có luôn field image_url
    // thì bỏ comment dòng dưới:
    // protected $appends = ['image_url'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Xử lý tiếng Việt trong slug
            $slug = Str::slug($product->name);

            // Đảm bảo slug là duy nhất
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $product->slug = $count ? "{$slug}-{$count}" : $slug;
        });

        static::updating(function ($product) {
            // Nếu đổi name thì cập nhật slug duy nhất
            if ($product->isDirty('name')) {
                $base = Str::slug($product->name);
                $slug = $base;
                $i = 2;

                while (
                    static::where('slug', $slug)
                        ->where('id', '<>', $product->id)
                        ->exists()
                ) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }

                $product->slug = $slug;
            }
        });
    }

    // Quan hệ
    public function category()  { return $this->belongsTo(Category::class); }
    public function brand()     { return $this->belongsTo(Brand::class); }
    public function variants()  { return $this->hasMany(ProductVariant::class); }
    public function images()    { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function mainImage() { return $this->hasOne(ProductImage::class)->where('is_main', true); }

    // Scope
    public function scopeActive($q) { return $q->where('is_active', true); }

    // Accessor: URL công khai để hiển thị ảnh
    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? Storage::url($this->image_path)   // => /storage/products/xxx.png (cần storage:link)
            : asset('images/placeholder-600x600.png'); // ảnh dự phòng
    }
}
