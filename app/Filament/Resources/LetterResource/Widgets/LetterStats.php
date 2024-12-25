<?php

namespace App\Filament\Resources\LetterResource\Widgets;

use App\Models\Letter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LetterStats extends BaseWidget
{
    protected ?string $heading = 'Letter Statistics'; // Remove 'static'

    public function getStats(): array
    {
        $totalLetters = Letter::count();
        $todayLetters = Letter::whereDate('letter_date', now()->toDateString())->count();
        $monthLetters = Letter::whereMonth('letter_date', now()->month)
            ->whereYear('letter_date', now()->year)
            ->count();

        return [
            Stat::make('Surat Hari Ini', $todayLetters),
            Stat::make('Surat Bulan Ini', $monthLetters),
            Stat::make('Total Surat', $totalLetters),
        ];
    }
}
