<?php

namespace App\Models;

use App\Enums\NurseryUserRole;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NurseryUser extends Pivot
{
    protected $casts = [
        'role' => NurseryUserRole::class,
    ];
}