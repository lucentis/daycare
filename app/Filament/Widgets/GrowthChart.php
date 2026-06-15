<?php

namespace App\Filament\Widgets;

use App\Models\Nursery;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class GrowthChart extends ChartWidget
{
    protected ?string $heading = 'Growth (Last 12 Months)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $months = collect(range(0, 11))
            ->map(fn (int $i) => now()->subMonths(11 - $i)->startOfMonth())
            ->values();

        $clientsBefore = User::role('client')
            ->where('created_at', '<', $months->first())
            ->count();

        $nurseriesBefore = Nursery::where('created_at', '<', $months->first())->count();

        $clientCounts = $this->cumulativeCounts(
            User::role('client')->pluck('created_at'),
            $months,
            $clientsBefore,
        );

        $nurseryCounts = $this->cumulativeCounts(
            Nursery::pluck('created_at'),
            $months,
            $nurseriesBefore,
        );

        return [
            'datasets' => [
                [
                    'label' => 'Clients',
                    'data' => $clientCounts,
                    'borderColor' => '#6366f1',
                    'fill' => false,
                ],
                [
                    'label' => 'Nurseries',
                    'data' => $nurseryCounts,
                    'borderColor' => '#10b981',
                    'fill' => false,
                ],
            ],
            'labels' => $months->map(fn (Carbon $month) => $month->format('M Y'))->all(),
        ];
    }

    /**
     * Build cumulative counts per month from a list of creation timestamps.
     *
     * @param  Collection<int, Carbon>  $createdAtDates
     * @param  Collection<int, Carbon>  $months
     */
    private function cumulativeCounts(Collection $createdAtDates, Collection $months, int $startingCount): array
    {
        $running = $startingCount;

        return $months->map(function (Carbon $month) use ($createdAtDates, &$running) {
            $endOfMonth = $month->copy()->endOfMonth();

            $running += $createdAtDates
                ->filter(fn ($date) => $date->between(
                    $month->copy()->startOfMonth(),
                    $endOfMonth,
                ))
                ->count();

            return $running;
        })->all();
    }

    protected function getType(): string
    {
        return 'line';
    }
}