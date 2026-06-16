<?php

namespace App\Filament\Resources\Nurseries\RelationManagers;

use App\Enums\NurseryUserRole;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
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
                CreateAction::make(),
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn ($query) => $query->role(['director', 'staff', 'client']))
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                    ])
                    ->using(function (array $data, $relationship) {
                        $user = \App\Models\User::find($data['recordId']);
                        $relationship->attach($data['recordId'], [
                            'role' => $user->getRoleNames()->first(),
                        ]);
                    }),
                ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
