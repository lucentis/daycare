<?php

namespace App\Filament\Resources\Nurseries\Schemas;

use App\Models\Nursery;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NurseryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('address'),
                TextEntry::make('phone'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('capacity')
                    ->numeric(),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Nursery $record): bool => $record->trashed()),
            ]);
    }
}
