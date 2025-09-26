<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class District extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['province_id','name'];

    protected static function booted()
    {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
