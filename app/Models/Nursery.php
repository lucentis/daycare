<?php

namespace App\Models;

use App\Enums\NurseryUserRole;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'address', 'phone', 'email', 'capacity', 'active'])]
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
            ->withTimestamps();
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(NurseryUser::class)
            ->whereHas('roles', fn (Builder $query) => $query->where('name', 'client'))
            ->withTimestamps();
    }

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(NurseryUser::class)
            ->whereHas('roles', fn (Builder $query) => $query->where('name', 'director'))
            ->withTimestamps();
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(NurseryUser::class)
            ->whereHas('roles', fn (Builder $query) => $query->where('name', 'staff'))
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