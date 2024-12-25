<?php

namespace App\Filament\Resources\LetterResource\Pages;

use App\Filament\Resources\LetterResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateLetter extends CreateRecord
{
    protected static string $resource = LetterResource::class;

    protected function afterSave(): void
    {
        // Redirect to the index page (list of letters) after saving
        $this->redirect(static::getResource()::getUrl('index'));
    }

    // Custom function for handling "Create Another" behavior
    protected function createAndRedirect()
    {
        // Save the record
        $this->save();

        // Redirect to the index page after saving
        $this->redirect(static::getResource()::getUrl('index'));
    }
}
