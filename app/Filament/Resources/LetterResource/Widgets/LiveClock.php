<?php

namespace App\Filament\Resources\LetterResource\Widgets;

use Filament\Widgets\Widget;

class LiveClock extends Widget
{
    protected static string $view = 'filament.resources.letter-resource.widgets.live-clock';

    public function getData(): array
    {
        return [
            'initialTime' => now()->format('H:i:s'),
        ];
    }
}
