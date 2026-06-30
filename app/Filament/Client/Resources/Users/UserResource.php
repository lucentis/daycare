<?php

namespace App\Filament\Client\Resources\Users;

use App\Filament\Client\Resources\Users\Pages\CreateUser;
use App\Filament\Client\Resources\Users\Pages\EditUser;
use App\Filament\Client\Resources\Users\Pages\ListUsers;
use App\Filament\Client\Resources\Users\Pages\ViewUser;
use App\Filament\Client\Resources\Users\Schemas\UserForm;
use App\Filament\Client\Resources\Users\Schemas\UserInfolist;
use App\Filament\Client\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Users\RelationManagers\ChildrenRelationManager;
use App\Filament\Resources\Users\RelationManagers\NurseriesRelationManager;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'utilisateur';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        $nurseryIds = auth()->user()->nurseries()->withTrashed()->pluck('nurseries.id');

        return parent::getEloquentQuery()
            ->where(
                fn (Builder $query) => $query
                    ->whereHas('nurseries', fn (Builder $q) => $q->whereIn('nurseries.id', $nurseryIds))
                    ->orWhereHas('children', fn (Builder $q) => $q->whereIn('children.nursery_id', $nurseryIds))
            );
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            NurseriesRelationManager::class,
            ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}