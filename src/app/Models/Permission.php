<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted() {
        static::creating(fn($model) => $model->id ?? $model->id = (string) Str::uuid());
    }

    protected $fillable = ['name','description'];

    public function roles() {
        return $this->belongsToMany(Role::class,'role_has_permissions');
    }
}
