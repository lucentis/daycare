<?php

namespace App\Filament\Resources\Nurseries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NurseryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->required(),
                TextInput::make('capacity')
                    ->required()
                    ->minValue(1)
                    ->numeric(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
