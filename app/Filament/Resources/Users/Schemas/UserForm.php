<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->tabs([
                        Tab::make('Information')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(
                                        table: 'users',
                                        column: 'email',
                                        ignoreRecord: true,
                                        modifyRuleUsing: fn ($rule) => $rule->whereNull('deleted_at'),
                                    )
                                    ->maxLength(255),

                                TextInput::make('password')
                                    ->password()
                                    ->required(fn (string $operation) => $operation === 'create')
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->maxLength(255),

                                DateTimePicker::make('email_verified_at')
                                    ->label('Email verified at'),

                                Select::make('roles')
                                    ->relationship('roles', 'name')
                                    ->preload()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
