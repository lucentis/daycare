<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
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
                ->icon(Heroicon::OutlinedUsers)
                ->badge(User::count()),
            'admins' => Tab::make('Admins')
                ->icon(Heroicon::OutlinedShieldCheck)
                ->badge(User::role('admin')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('admin')),
            'directors' => Tab::make('Directeurs')
                ->icon(Heroicon::OutlinedBriefcase)
                ->badge(User::role('director')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('director')),
            'staff' => Tab::make('Staff')
                ->icon(Heroicon::OutlinedUserGroup)
                ->badge(User::role('staff')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('staff')),
            'parents' => Tab::make('Parents')
                ->icon(Heroicon::OutlinedHeart)
                ->badge(User::role('parent')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->role('parent')),
        ];
    }
}
