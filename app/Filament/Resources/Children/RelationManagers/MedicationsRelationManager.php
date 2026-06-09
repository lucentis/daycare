<?php

namespace App\Filament\Resources\Children\RelationManagers;

use App\Filament\Resources\Medications\MedicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class MedicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'medications';

    protected static ?string $relatedResource = MedicationResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
