<?php

namespace App\Filament\Resources\Children\RelationManagers;

use App\Enums\AllergySeverity;
use App\Filament\Resources\Allergies\AllergyResource;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AllergiesRelationManager extends RelationManager
{
    protected static string $relationship = 'allergies';

    protected static ?string $relatedResource = AllergyResource::class;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->allergies()->count() ?: null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('pivot.severity')
                    ->label('Sévérité')
                    ->badge()
                    ->color(fn (AllergySeverity $state): string => match ($state) {
                        AllergySeverity::Mild => 'success',
                        AllergySeverity::Moderate => 'warning',
                        AllergySeverity::Severe => 'danger',
                    }),
                TextColumn::make('pivot.notes')
                    ->label('Notes')
                    ->placeholder('-'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        Select::make('severity')
                            ->options(AllergySeverity::class)
                            ->required(),
                        Textarea::make('notes')
                            ->nullable(),
                    ]),
                CreateAction::make(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);;
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
