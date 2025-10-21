<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model{
  use HasFactory;
  protected $fillable = ['name','slug','sku','price','stock','description','image_path','category_id','type'];
  protected $casts = ['meta'=>'array'];

  protected static function boot()
  {
      parent::boot();
      static::creating(function ($product) {
          // Xử lý tiếng Việt trong slug
          $slug = \Str::slug($product->name);
          
          // Đảm bảo slug là duy nhất
          $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
          
          $product->slug = $count ? "{$slug}-{$count}" : $slug;
      });
  }
  public function category(){ return $this->belongsTo(Category::class); }
  public function brand(){ return $this->belongsTo(Brand::class); }
  public function variants(){ return $this->hasMany(ProductVariant::class); }
  public function images(){ return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
  public function mainImage(){ return $this->hasOne(ProductImage::class)->where('is_main',true); }
  public function scopeActive($q){ return $q->where('is_active',true); }
}
