<?php

namespace App\Filament\Resources\LetterResource\Widgets;

use App\Models\Letter;
use Filament\Widgets\ChartWidget;

class DailyLetterChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Surat Hari Ini';

    /**
     * Define the chart type as a line chart.
     */
    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Prepare data for the chart.
     */
    protected function getData(): array
    {
        // Get data for the last 7 days
        $dailyLetters = Letter::query()
            ->selectRaw('DATE(letter_date) as date, COUNT(*) as count')
            ->whereBetween('letter_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(fn($item) => [$item->date => $item->count]);

        // Fill missing dates with 0
        $dailyData = collect(range(0, 6))->mapWithKeys(function ($daysAgo) use ($dailyLetters) {
            $date = now()->subDays($daysAgo)->format('Y-m-d');
            return [$date => $dailyLetters[$date] ?? 0];
        })->reverse();

        // Get data for the current year grouped by month
        $monthlyLetters = Letter::query()
            ->selectRaw('MONTH(letter_date) as month, COUNT(*) as count')
            ->whereYear('letter_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(fn($item) => [$item->month => $item->count]);

        // Fill missing months with 0
        $monthlyData = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyLetters) {
            return [$month => $monthlyLetters[$month] ?? 0];
        });

        // Return data formatted for the chart
        return [
            'datasets' => [
                [
                    'label' => 'Grafik Harian',
                    'data' => $dailyData->values()->all(),
                    'borderColor' => '#f87171',
                    'backgroundColor' => 'rgba(248, 113, 113, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => [
                ...$dailyData->keys()->all(), // Daily labels (dates)
            ],
        ];
    }
}
