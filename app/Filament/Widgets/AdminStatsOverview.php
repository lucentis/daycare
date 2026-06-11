<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use App\Models\Nursery;
use App\Models\Transmission;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $childrenWithoutTransmission = Child::active()
            ->whereDoesntHave('transmissions', fn ($q) => $q->whereDate('noted_at', today()))
            ->count();

        return [
            Stat::make('Active Nurseries', Nursery::active()->count())
                ->icon('heroicon-o-building-office')
                ->color('primary'),

            Stat::make('Active Children', Child::active()->count())
                ->icon('heroicon-o-face-smile')
                ->color('success'),

            Stat::make('Staff', User::staff()->count())
                ->icon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('Parents', User::parents()->count())
                ->icon('heroicon-o-heart')
                ->color('warning'),

            Stat::make('Transmissions Today', Transmission::whereDate('noted_at', today())->count())
                ->icon('heroicon-o-clipboard-document-list')
                ->color('success'),

            Stat::make('Children Without Transmission Today', $childrenWithoutTransmission)
                ->icon('heroicon-o-exclamation-triangle')
                ->color($childrenWithoutTransmission > 0 ? 'danger' : 'success'),
        ];
    }
}
