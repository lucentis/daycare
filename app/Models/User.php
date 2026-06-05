<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function nurseries(): BelongsToMany
    {
        return $this->belongsToMany(Nursery::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)
            ->withPivot('relation')
            ->withTimestamps();
    }

    public function transmissions(): HasMany
    {
        return $this->hasMany(Transmission::class, 'author_id');
    }

    public function scopeDirectors(Builder $query): Builder
    {
        return $query->role('director');
    }

    public function scopeStaff(Builder $query): Builder
    {
        return $query->role('staff');
    }

    public function scopeParents(Builder $query): Builder
    {
        return $query->role('parent');
    }
}