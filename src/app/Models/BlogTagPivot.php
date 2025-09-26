<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BlogTagPivot extends Pivot
{
    protected $table = 'blog_tag_pivot';
    public $incrementing = false;
    protected $keyType = 'string';
}
