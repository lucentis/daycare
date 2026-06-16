<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use App\Models\Nursery;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Collection;

class RecentlyDeletedTable extends BaseWidget
{
    protected static ?string $heading = 'Recently Deleted';

    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->records(fn() => $this->recentlyDeleted())
            ->columns([
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('name'),
                TextColumn::make('deleted_at')
                    ->dateTime(),
            ]);
    }

    private function recentlyDeleted(): Collection
    {
        $users = User::onlyTrashed()->latest('deleted_at')->take(10)->get()
            ->map(fn (User $user) => [
                'type' => 'User',
                'name' => $user->name,
                'deleted_at' => $user->deleted_at,
            ]);

        $nurseries = Nursery::onlyTrashed()->latest('deleted_at')->take(10)->get()
            ->map(fn (Nursery $nursery) => [
                'type' => 'Nursery',
                'name' => $nursery->name,
                'deleted_at' => $nursery->deleted_at,
            ]);

        $children = Child::onlyTrashed()->latest('deleted_at')->take(10)->get()
            ->map(fn (Child $child) => [
                'type' => 'Child',
                'name' => $child->full_name,
                'deleted_at' => $child->deleted_at,
            ]);

        return $users->merge($nurseries)->merge($children)
            ->sortByDesc('deleted_at')
            ->take(10)
            ->values();
    }
}