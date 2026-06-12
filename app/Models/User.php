<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
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

#[Fillable(['name', 'email', 'password', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        return match($panel->getId()) {
            'admin' => $this->hasRole('admin'),
            'director' => $this->hasRole('director'),
            'staff' => $this->hasRole('staff'),
            default => false,
        };
    }
    
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
            ->using(NurseryUser::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)
            ->using(ChildUser::class)
            ->withPivot('relation')
            ->withTimestamps();
    }

    public function transmissions(): HasMany
    {
        return $this->hasMany(Transmission::class, 'author_id');
    }

    public function scopeClients(Builder $query): Builder
    {
        return $query->role('client');
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