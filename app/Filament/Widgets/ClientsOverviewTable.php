<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ClientsOverviewTable extends BaseWidget
{
    protected static ?string $heading = 'Clients Overview';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::role('client')
                    ->withCount('nurseries')
                    ->with('nurseries.children', 'nurseries.users')
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('nurseries_count')
                    ->label('Nurseries')
                    ->sortable(),
                TextColumn::make('active_children_count')
                    ->label('Active Children')
                    ->state(fn (User $record) => $record->nurseries
                        ->flatMap(fn ($nursery) => $nursery->children)
                        ->where('active', true)
                        ->count()),
                TextColumn::make('team_members_count')
                    ->label('Team Members')
                    ->state(fn (User $record) => $record->nurseries
                        ->flatMap(fn ($nursery) => $nursery->users)
                        ->filter(fn ($user) => $user->hasAnyRole(['director', 'staff']))
                        ->unique('id')
                        ->count()),
                TextColumn::make('created_at')
                    ->label('Client since')
                    ->date()
                    ->sortable(),
            ]);
    }
}