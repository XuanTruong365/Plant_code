<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function ($model) {
            if(!$model->id) $model->id = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'name','email','password','phone','avatar','status','role'
    ];

    protected $hidden = ['password'];

    // Relations
    public function addresses() {
        return $this->hasMany(UserAddress::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function coupons() {
        return $this->belongsToMany(Coupon::class,'coupon_user');
    }

    public function activityLogs() {
        return $this->hasMany(ActivityLog::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'created_by');
    }

}
