<?php

namespace App\Filament\Resources\LetterResource\Widgets;

use App\Models\Letter;
use Filament\Widgets\ChartWidget;

class MonthlyLetterChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Surat Bulan Ini';

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

        // Get the current month to locale
        $currentMonth = now()->locale('id')->monthName;

        // Return data formatted for the chart
        return [
            'datasets' => [
                [
                    'label' => $currentMonth,
                    'data' => $monthlyData->values()->all(),
                    'borderColor' => '#34d399',
                    'backgroundColor' => 'rgba(52, 211, 153, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => [
                ...range(1, 12), // Monthly labels (month numbers)
            ],
        ];
    }
}
