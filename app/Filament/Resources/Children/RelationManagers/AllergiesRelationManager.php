<?php

namespace App\Filament\Resources\Children\RelationManagers;

use App\Filament\Resources\Allergies\AllergyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class AllergiesRelationManager extends RelationManager
{
    protected static string $relationship = 'allergies';

    protected static ?string $relatedResource = AllergyResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
