<?php

namespace App\Filament\Resources\Nurseries\RelationManagers;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $relatedResource = UserResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->modal()
                    ->createAnother(false),
                AttachAction::make()
                    ->preloadRecordSelect()
                ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
