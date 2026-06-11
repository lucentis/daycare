<?php

namespace App\Filament\Resources\Transmissions\Schemas;

use App\Enums\DiaperCondition;
use App\Enums\DiaperType;
use App\Enums\MealQuantity;
use App\Enums\MealType;
use App\Enums\NapQuality;
use App\Enums\TransmissionType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class TransmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('child_id')
                    ->relationship('child', 'first_name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}"),

                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required()
                    ->preload(),

                Select::make('type')
                    ->options(TransmissionType::class)
                    ->required()
                    ->live(),

                DateTimePicker::make('noted_at')
                    ->required(),

                Textarea::make('notes')
                    ->columnSpanFull(),

                // Nap
                Section::make('Nap details')
                    ->schema([
                        TimePicker::make('payload.start_at')->required(),
                        TimePicker::make('payload.end_at')->required(),
                        Select::make('payload.quality')
                            ->options(NapQuality::class)
                            ->required(),
                    ])
                    ->visible(fn ($get) => $get('type')?->value === TransmissionType::Nap->value)
                    ->columnSpanFull(),

                // Meal
                Section::make('Meal details')
                    ->schema([
                        Select::make('payload.meal_type')
                            ->options(MealType::class)
                            ->required(),
                        Toggle::make('payload.ate_well'),
                        Select::make('payload.quantity')
                            ->options(MealQuantity::class)
                            ->required(),
                        TextInput::make('payload.menu'),
                    ])
                    ->visible(fn ($get) => $get('type')?->value === TransmissionType::Meal->value)
                    ->columnSpanFull(),

                // Diaper
                Section::make('Diaper details')
                    ->schema([
                        Select::make('payload.type')
                            ->options(DiaperType::class)
                            ->required(),
                        Select::make('payload.condition')
                            ->options(DiaperCondition::class)
                            ->required(),
                    ])
                    ->visible(fn ($get) => $get('type')?->value === TransmissionType::Diaper->value)
                    ->columnSpanFull(),

                // Activity
                Section::make('Activity details')
                    ->schema([
                        TextInput::make('payload.name')->required(),
                        Textarea::make('payload.description'),
                    ])
                    ->visible(fn ($get) => $get('type')?->value === TransmissionType::Activity->value)
                    ->columnSpanFull(),

                // Health
                Section::make('Health details')
                    ->schema([
                        TextInput::make('payload.temperature')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('payload.symptoms')
                            ->nullable(),
                        Toggle::make('payload.medicine_given')
                            ->live(),
                        TextInput::make('payload.medicine_name')
                            ->visible(fn ($get) => $get('payload.medicine_given')),
                        TextInput::make('payload.medicine_dose')
                            ->visible(fn ($get) => $get('payload.medicine_given')),
                    ])
                    ->visible(fn ($get) => $get('type')?->value === TransmissionType::Health->value)
                    ->columnSpanFull(),

                // Note
                Section::make('Note details')
                    ->schema([
                        Textarea::make('payload.content')->required(),
                    ])
                    ->visible(fn ($get) => $get('type')?->value === TransmissionType::Note->value)
                    ->columnSpanFull(),
            ]);
    }
}