<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted() {
        static::creating(function ($model) {
            if(!$model->id) $model->id = (string) Str::uuid();
        });
    }

    protected $fillable = ['product_id','name','sku','price','stock_qty'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }
}
