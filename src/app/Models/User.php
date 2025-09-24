<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // nếu dùng API Token

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ⚡ UUID setup
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'email', 'password', 'phone', 'avatar', 'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ⚡ Auto-generate UUID khi tạo mới
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function addresses()
    {
//        return $this->hasMany(UserAddress::class);
    }

    public function orders()
    {
//        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
//        return $this->hasMany(Review::class);
    }

}
