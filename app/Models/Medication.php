<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medication extends Model
{
    use HasFactory;

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)
            ->withPivot('dosage', 'frequency', 'notes', 'active', 'started_at', 'ended_at')
            ->withTimestamps();
    }
}