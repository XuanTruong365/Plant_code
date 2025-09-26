<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Province extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    protected static function booted()
    {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
