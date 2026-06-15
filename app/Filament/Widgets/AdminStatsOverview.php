<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use App\Models\Nursery;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Clients', User::role('client')->count())
                ->icon('heroicon-o-briefcase')
                ->color('primary'),

            Stat::make('Nurseries', Nursery::count())
                ->icon('heroicon-o-building-office')
                ->color('info'),

            Stat::make('Active Children', Child::active()->count())
                ->icon('heroicon-o-face-smile')
                ->color('success'),

            Stat::make('Team Members', User::role(['director', 'staff'])->count())
                ->icon('heroicon-o-user-group')
                ->color('warning'),
        ];
    }
}