<?php

namespace App\Filament\Resources\SmartCityContents\Pages;

use App\Filament\Resources\SmartCityContents\SmartCityContentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSmartCityContents extends ListRecords
{
    protected static string $resource = SmartCityContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
