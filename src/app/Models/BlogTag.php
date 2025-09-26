<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name','slug'];

    protected static function booted()
    {
        static::creating(fn($model) => $model->id ??= (string) Str::uuid());
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag_pivot')
            ->withTimestamps();
    }
}
