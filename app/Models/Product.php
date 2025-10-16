<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model{
  use HasFactory;
  protected $fillable = ['category_id','brand_id','name','slug','sku','description','price','sale_price','is_active','meta'];
  protected $casts = ['meta'=>'array'];
  public function category(){ return $this->belongsTo(Category::class); }
  public function brand(){ return $this->belongsTo(Brand::class); }
  public function variants(){ return $this->hasMany(ProductVariant::class); }
  public function images(){ return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
  public function mainImage(){ return $this->hasOne(ProductImage::class)->where('is_main',true); }
  public function scopeActive($q){ return $q->where('is_active',true); }
}
