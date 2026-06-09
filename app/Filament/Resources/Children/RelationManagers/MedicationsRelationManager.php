<?php

namespace App\Filament\Resources\Children\RelationManagers;

use App\Filament\Resources\Medications\MedicationResource;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MedicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'medications';

    protected static ?string $relatedResource = MedicationResource::class;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Medications';
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->medications()->count() ?: null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('pivot.dosage')
                    ->label('Dosage'),
                TextColumn::make('pivot.frequency')
                    ->label('Fréquence'),
                IconColumn::make('pivot.active')
                    ->label('Actif')
                    ->boolean(),
                TextColumn::make('pivot.started_at')
                    ->label('Started at')
                    ->date(),
                TextColumn::make('pivot.ended_at')
                    ->label('Ended at')
                    ->date()
                    ->placeholder('-'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        TextInput::make('dosage')->required(),
                        TextInput::make('frequency')->required(),
                        Textarea::make('notes')->nullable(),
                        Toggle::make('active')->default(true),
                        DatePicker::make('started_at')->required(),
                        DatePicker::make('ended_at')->nullable(),
                    ]),
                CreateAction::make(),
            ]);
    }
}
