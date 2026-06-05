<?php

namespace App\Models;

use App\Enums\AllergySeverity;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AllergyChild extends Pivot
{
    protected $casts = [
        'severity' => AllergySeverity::class,
    ];
}