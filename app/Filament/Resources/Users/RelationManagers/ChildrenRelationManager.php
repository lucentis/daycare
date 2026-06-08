<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Enums\ChildUserRelation;
use App\Filament\Resources\Children\ChildResource;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $relatedResource = ChildResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        Select::make('relation')
                            ->options(ChildUserRelation::class)
                            ->required(),
                    ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->hasAnyRole(['parent']);
    }
}
