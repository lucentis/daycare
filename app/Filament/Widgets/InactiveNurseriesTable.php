<?php

namespace App\Filament\Widgets;

use App\Models\Nursery;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class InactiveNurseriesTable extends BaseWidget
{
    protected static ?string $heading = 'Inactive Nurseries';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Nursery::where('active', false)
                    ->with('clients')
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('clients.name')
                    ->label('Client')
                    ->placeholder('-'),
                TextColumn::make('updated_at')
                    ->label('Deactivated')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}