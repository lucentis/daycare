<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildMedication extends Pivot
{
    protected $casts = [
        'active' => 'boolean',
        'started_at' => 'date',
        'ended_at' => 'date',
    ];
}