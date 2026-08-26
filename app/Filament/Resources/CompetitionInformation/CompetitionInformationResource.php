<?php

namespace App\Filament\Resources\CompetitionInformation;

use App\Filament\Resources\CompetitionInformation\Pages\CreateCompetitionInformation;
use App\Filament\Resources\CompetitionInformation\Pages\EditCompetitionInformation;
use App\Filament\Resources\CompetitionInformation\Pages\ListCompetitionInformation;
use App\Filament\Resources\CompetitionInformation\Schemas\CompetitionInformationForm;
use App\Filament\Resources\CompetitionInformation\Tables\CompetitionInformationTable;
use App\Models\CompetitionInformation as CompetitionInformationModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompetitionInformationResource extends Resource
{
    protected static ?string $model = CompetitionInformationModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Competition & organizer';

    protected static ?string $modelLabel = 'competition information block';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CompetitionInformationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompetitionInformationTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompetitionInformation::route('/'),
            'create' => CreateCompetitionInformation::route('/create'),
            'edit' => EditCompetitionInformation::route('/{record}/edit'),
        ];
    }
}
