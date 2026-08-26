<?php

namespace App\Filament\Resources\CompetitionInformation\Pages;

use App\Filament\Resources\CompetitionInformation\CompetitionInformationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompetitionInformation extends EditRecord
{
    protected static string $resource = CompetitionInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
