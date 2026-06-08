<?php

namespace App\Filament\Resources\Children\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ChildForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nursery_id')
                    ->relationship('nursery', 'name')
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->required(),
                TextInput::make('photo'),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
