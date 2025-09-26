<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'order_id', 'amount', 'method', 'transaction_id',
        'status', 'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
