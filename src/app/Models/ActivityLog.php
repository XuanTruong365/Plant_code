<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id', 'description', 'ip_address'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id ??= (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
