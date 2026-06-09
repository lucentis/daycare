<?php

namespace App\Filament\Resources\Transmissions;

use App\Filament\Resources\Transmissions\Pages\CreateTransmission;
use App\Filament\Resources\Transmissions\Pages\EditTransmission;
use App\Filament\Resources\Transmissions\Pages\ListTransmissions;
use App\Filament\Resources\Transmissions\Pages\ViewTransmission;
use App\Filament\Resources\Transmissions\Schemas\TransmissionForm;
use App\Filament\Resources\Transmissions\Schemas\TransmissionInfolist;
use App\Filament\Resources\Transmissions\Tables\TransmissionsTable;
use App\Models\Transmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TransmissionResource extends Resource
{
    protected static ?string $model = Transmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'type';

    protected static ?int $navigationSort = 4;

    public static function getRecordTitle(?Model $record): string
    {
        return $record->type->value . ' - ' . $record->child->full_name;
    }

    public static function form(Schema $schema): Schema
    {
        return TransmissionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransmissionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransmissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransmissions::route('/'),
            'create' => CreateTransmission::route('/create'),
            'view' => ViewTransmission::route('/{record}'),
            'edit' => EditTransmission::route('/{record}/edit'),
        ];
    }
}
