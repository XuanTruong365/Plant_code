<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted() {
        static::creating(fn($model) => $model->id ?? $model->id = (string) Str::uuid());
    }

    protected $fillable = ['name','description'];

    public function permissions() {
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }

    public function users() {
        return $this->morphedByMany(User::class,'model','model_has_roles');
    }
}
