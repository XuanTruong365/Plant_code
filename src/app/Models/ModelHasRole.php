<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelHasRole extends MorphPivot
{
    protected $table = 'model_has_roles';
    public $incrementing = false;
    protected $keyType = 'string';
}
