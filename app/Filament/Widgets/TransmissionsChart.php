<?php

namespace App\Filament\Widgets;

use App\Enums\TransmissionType;
use App\Models\Transmission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TransmissionsChart extends ChartWidget
{
    protected ?string $heading = 'Transmissions by Type (Last 30 Days)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        foreach (TransmissionType::cases() as $type) {
            $data[] = Transmission::where('type', $type)
                ->whereDate('noted_at', '>=', now()->subDays(30))
                ->count();
            $labels[] = $type->label();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Transmissions',
                    'data' => $data,
                    'backgroundColor' => [
                        '#6366f1',
                        '#f59e0b',
                        '#10b981',
                        '#3b82f6',
                        '#ef4444',
                        '#8b5cf6',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}