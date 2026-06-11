<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ChildrenWithoutTransmissionTable extends BaseWidget
{
    protected static ?string $heading = 'Children Without Transmission Today';

    protected static ?int $sort = 3;

    // protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Child::active()
                    ->whereDoesntHave('transmissions', fn ($q) => $q->whereDate('noted_at', today()))
                    ->with('nursery')
            )
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('nursery.name')
                    ->label('Nursery'),
                TextColumn::make('date_of_birth')
                    ->date(),
            ]);
    }
}