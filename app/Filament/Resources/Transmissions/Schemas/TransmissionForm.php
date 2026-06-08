<?php

namespace App\Filament\Resources\Transmissions\Schemas;

use App\Enums\TransmissionType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('child_id')
                    ->relationship('child', 'id')
                    ->required(),
                Select::make('nursery_id')
                    ->relationship('nursery', 'name')
                    ->required(),
                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required(),
                Select::make('type')
                    ->options(TransmissionType::class)
                    ->required(),
                Textarea::make('payload')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('noted_at')
                    ->required(),
            ]);
    }
}
