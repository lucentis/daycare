<?php

namespace App\Filament\Resources\Children\RelationManagers;

use App\Filament\Resources\Transmissions\TransmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class TransmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transmissions';

    protected static ?string $relatedResource = TransmissionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
