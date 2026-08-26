<?php

namespace App\Filament\Resources\CompetitionInformation\Pages;

use App\Filament\Resources\CompetitionInformation\CompetitionInformationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompetitionInformation extends ListRecords
{
    protected static string $resource = CompetitionInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
