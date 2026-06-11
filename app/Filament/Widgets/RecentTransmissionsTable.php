<?php

namespace App\Filament\Widgets;

use App\Models\Transmission;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentTransmissionsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Transmissions';

    protected static ?int $sort = 4;

    // protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transmission::query()
                    ->with(['child', 'nursery', 'author'])
                    ->latest('noted_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('child.full_name')
                    ->label('Child'),
                TextColumn::make('nursery.name')
                    ->label('Nursery'),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('author.name')
                    ->label('Author'),
                TextColumn::make('noted_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}