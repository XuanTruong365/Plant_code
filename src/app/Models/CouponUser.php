<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CouponUser extends Pivot
{
    protected $table = 'coupon_user';
    public $incrementing = false;
    protected $keyType = 'string';
}
