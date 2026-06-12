<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Enums\NurseryUserRole;
use App\Filament\Resources\Nurseries\NurseryResource;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NurseriesRelationManager extends RelationManager
{
    protected static string $relationship = 'nurseries';

    protected static ?string $relatedResource = NurseryResource::class;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Crèches';
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->nurseries()->count();
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('pivot.role')
                    ->label('Role')
                    ->badge(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        Select::make('role')
                            ->options(NurseryUserRole::class)
                            ->required(),
                    ]),
                CreateAction::make()
                    ->visible($this->getOwnerRecord()->hasRole('client')),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->hasAnyRole(['client', 'director', 'staff']);
    }

    public function isReadOnly(): bool
    {
        return false;
    } 
}
