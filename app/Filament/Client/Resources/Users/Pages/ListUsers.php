<?php

namespace App\Filament\Client\Resources\Users\Pages;

use App\Filament\Client\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous')
                ->icon(Heroicon::OutlinedUsers),
            'directors' => Tab::make('Directeurs')
                ->icon(Heroicon::OutlinedBriefcase)
                ->badge(UserResource::getEloquentQuery()->role('director')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('director')),
            'staff' => Tab::make('Staff')
                ->icon(Heroicon::OutlinedUserGroup)
                ->badge(UserResource::getEloquentQuery()->role('staff')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('staff')),
            'parents' => Tab::make('Parents')
                ->icon(Heroicon::OutlinedHeart)
                ->badge(UserResource::getEloquentQuery()->role('parent')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('parent')),
        ];
    }
}