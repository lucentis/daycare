<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ClientsWithoutNurseryTable extends BaseWidget
{
    protected static ?string $heading = 'Clients Without a Nursery';

    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::role('client')->doesntHave('nurseries')
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('created_at')
                    ->label('Client since')
                    ->date()
                    ->sortable(),
            ]);
    }
}