<?php

namespace App\Filament\Resources\SmartCityContents;

use App\Filament\Resources\SmartCityContents\Pages\CreateSmartCityContent;
use App\Filament\Resources\SmartCityContents\Pages\EditSmartCityContent;
use App\Filament\Resources\SmartCityContents\Pages\ListSmartCityContents;
use App\Filament\Resources\SmartCityContents\Schemas\SmartCityContentForm;
use App\Filament\Resources\SmartCityContents\Tables\SmartCityContentsTable;
use App\Models\SmartCityContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SmartCityContentResource extends Resource
{
    protected static ?string $model = SmartCityContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Smart Green City';

    protected static ?string $modelLabel = 'Smart Green City block';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SmartCityContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SmartCityContentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSmartCityContents::route('/'),
            'create' => CreateSmartCityContent::route('/create'),
            'edit' => EditSmartCityContent::route('/{record}/edit'),
        ];
    }
}
