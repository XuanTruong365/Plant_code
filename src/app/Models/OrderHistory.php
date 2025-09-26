<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderHistory extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['order_id','status','note'];

    protected static function booted() {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
