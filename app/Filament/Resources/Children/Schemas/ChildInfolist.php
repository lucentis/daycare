<?php

namespace App\Filament\Resources\Children\Schemas;

use App\Models\Child;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ChildInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nursery.name')
                    ->label('Nursery'),
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('date_of_birth')
                    ->date(),
                TextEntry::make('photo')
                    ->placeholder('-'),
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
                    ->visible(fn (Child $record): bool => $record->trashed()),
            ]);
    }
}
