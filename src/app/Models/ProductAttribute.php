<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductAttribute extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted() {
        static::creating(function ($model) {
            if(!$model->id) $model->id = (string) Str::uuid();
        });
    }

    protected $fillable = ['product_id','key','value'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
