<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Allergy extends Model
{
    use HasFactory;

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)
            ->withPivot('severity', 'notes')
            ->withTimestamps();
    }
}