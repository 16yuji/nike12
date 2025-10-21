<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model{
  use HasFactory;
  protected $fillable = ['user_id','code','subtotal','discount','shipping_fee','total','status','payment_method','shipping_name','shipping_phone','shipping_address'];
  
  public function items(){ 
    return $this->hasMany(OrderItem::class); 
  }
  
  public function user(){
    return $this->belongsTo(User::class);
  }
}
