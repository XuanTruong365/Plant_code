<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartItem extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['cart_id','product_id','quantity','price'];

    protected static function booted() {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
