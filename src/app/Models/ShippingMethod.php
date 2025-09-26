<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShippingMethod extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name', 'fee', 'estimated_days', 'status'
    ];

    protected static function booted()
    {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
