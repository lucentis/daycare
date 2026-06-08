<?php

namespace App\Filament\Resources\Transmissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('child.id')
                    ->label('Child'),
                TextEntry::make('nursery.name')
                    ->label('Nursery'),
                TextEntry::make('author.name')
                    ->label('Author'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('payload')
                    ->columnSpanFull(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('noted_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
