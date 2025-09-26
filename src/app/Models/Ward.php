<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ward extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['district_id','name'];

    protected static function booted()
    {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
