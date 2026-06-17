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
                    ->state(fn ($record) => class_basename($record))
                    ->badge(),
                TextColumn::make('name')
                    ->state(fn ($record) => match (true) {
                        $record instanceof Child => $record->full_name,
                        default => $record->name
                    }),
                TextColumn::make('deleted_at')
                    ->dateTime(),
            ]);
    }

    private function recentlyDeleted(): Collection
    {
        $users = User::onlyTrashed()->latest('deleted_at')->take(10)->get();

        $nurseries = Nursery::onlyTrashed()->latest('deleted_at')->take(10)->get();

        $children = Child::onlyTrashed()->latest('deleted_at')->take(10)->get();

        return $users->merge($nurseries)->merge($children)
            ->sortByDesc('deleted_at')
            ->take(10)
            ->values();
    }
}