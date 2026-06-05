<?php

namespace App\Models;

use App\Enums\NurseryUserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nursery extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'active' => 'boolean',
        'capacity' => 'integer',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(NurseryUser::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(NurseryUser::class)
            ->withPivot('role')
            ->wherePivot('role', NurseryUserRole::Director)
            ->withTimestamps();
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(NurseryUser::class)
            ->withPivot('role')
            ->wherePivot('role', NurseryUserRole::Staff)
            ->withTimestamps();
    }   

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }

    public function transmissions(): HasMany
    {
        return $this->hasMany(Transmission::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}