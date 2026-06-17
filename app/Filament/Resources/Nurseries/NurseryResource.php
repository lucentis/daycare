<?php

namespace App\Filament\Resources\Nurseries;

use App\Filament\Resources\Nurseries\Pages\CreateNursery;
use App\Filament\Resources\Nurseries\Pages\EditNursery;
use App\Filament\Resources\Nurseries\Pages\ListNurseries;
use App\Filament\Resources\Nurseries\Pages\ViewNursery;
use App\Filament\Resources\Nurseries\Schemas\NurseryForm;
use App\Filament\Resources\Nurseries\Schemas\NurseryInfolist;
use App\Filament\Resources\Nurseries\Tables\NurseriesTable;
use App\Models\Nursery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NurseryResource extends Resource
{
    protected static ?string $model = Nursery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'crèche';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return NurseryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NurseryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NurseriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UserRelationManager::class,
            RelationManagers\ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNurseries::route('/'),
            'create' => CreateNursery::route('/create'),
            'view' => ViewNursery::route('/{record}'),
            'edit' => EditNursery::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (! auth()->user()->hasRole('admin')) {
            $query->whereHas('users', fn (Builder $query) => $query->where('users.id', auth()->id()));
        }

        return $query;
    }
}
