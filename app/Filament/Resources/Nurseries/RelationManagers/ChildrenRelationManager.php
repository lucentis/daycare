<?php

namespace App\Filament\Resources\Nurseries\RelationManagers;

use App\Filament\Resources\Children\ChildResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $relatedResource = ChildResource::class;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Enfants';
    }

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
