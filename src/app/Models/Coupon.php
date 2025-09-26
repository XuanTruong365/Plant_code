<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount',
        'max_discount', 'start_date', 'end_date',
        'usage_limit', 'used_count', 'status'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id ??= (string) Str::uuid();
            $model->used_count ??= 0;
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withTimestamps();
    }
}
