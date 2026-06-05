<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'date_of_birth' => 'date',
        'active' => 'boolean',
    ];

    public function nursery(): BelongsTo
    {
        return $this->belongsTo(Nursery::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(ChildUser::class)
            ->withPivot('relation')
            ->withTimestamps();
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(ChildUser::class)
            ->withPivot('relation')
            ->withTimestamps();
    }

    public function transmissions(): HasMany
    {
        return $this->hasMany(Transmission::class);
    }

    public function allergies(): BelongsToMany
    {
        return $this->belongsToMany(Allergy::class)
            ->using(AllergyChild::class)
            ->withPivot('severity', 'notes')
            ->withTimestamps();
    }

    public function medications(): BelongsToMany
    {
        return $this->belongsToMany(Medication::class)
            ->using(ChildMedication::class)
            ->withPivot('dosage', 'frequency', 'notes', 'active', 'started_at', 'ended_at')
            ->withTimestamps();
    }

    public function activeMedications(): BelongsToMany
    {
        return $this->belongsToMany(Medication::class)
            ->using(ChildMedication::class)
            ->withPivot('dosage', 'frequency', 'notes', 'active', 'started_at', 'ended_at')
            ->wherePivot('active', true)
            ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeForNursery(Builder $query, int $nurseryId): Builder
    {
        return $query->where('nursery_id', $nurseryId);
    }

    public function scopeForParent(Builder $query, int $userId): Builder
    {
        return $query->whereHas('users', function (Builder $query) use ($userId) {
            $query->where('users.id', $userId);
        });
    }
}