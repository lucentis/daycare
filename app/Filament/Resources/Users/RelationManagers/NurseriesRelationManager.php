<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Enums\NurseryUserRole;
use App\Filament\Resources\Nurseries\NurseryResource;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

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

    // public function form(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             Select::make('role')
    //                 ->default(NurseryUserRole::Client->value),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                // TextColumn::make('pivot.role')
                //     ->label('Role')
                //     ->badge(),
                IconColumn::make('active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    // ->schema(fn (AttachAction $action) => [
                    //     $action->getRecordSelect(),
                    //     Select::make('role')
                    //         ->options(NurseryUserRole::class)
                    //         ->required(),
                    // ])
                    ,
                CreateAction::make()
                    ->modal()
                    // ->mutateDataUsing(function (array $data): array {
                    //     $data['role'] = NurseryUserRole::Client->value;

                    //     return $data;
                    // })
                    ->createAnother(false) 
                    ->visible(fn () => $this->getOwnerRecord()->hasRole('client'))
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DetachAction::make()
                    ->requiresConfirmation(),
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
