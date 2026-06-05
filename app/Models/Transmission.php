<?php

namespace App\Models;

use App\Enums\TransmissionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transmission extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => TransmissionType::class,
        'payload' => 'array',
        'noted_at' => 'datetime',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function nursery(): BelongsTo
    {
        return $this->belongsTo(Nursery::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeForChild(Builder $query, int $childId): Builder
    {
        return $query->where('child_id', $childId);
    }

    public function scopeForNursery(Builder $query, int $nurseryId): Builder
    {
        return $query->where('nursery_id', $nurseryId);
    }

    public function scopeOfType(Builder $query, TransmissionType $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('noted_at', $date);
    }
}