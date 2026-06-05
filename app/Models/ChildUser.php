<?php

namespace App\Models;

use App\Enums\ChildUserRelation;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildUser extends Pivot
{
    protected $casts = [
        'relation' => ChildUserRelation::class,
    ];
}