<?php

namespace App\Filament\Resources\SmartCityContents\Pages;

use App\Filament\Resources\SmartCityContents\SmartCityContentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSmartCityContent extends EditRecord
{
    protected static string $resource = SmartCityContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
