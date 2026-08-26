<?php

namespace App\Filament\Resources\CompetitionInformation\Schemas;

use App\Models\CompetitionInformation as CompetitionInformationModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompetitionInformationForm
{
    /**
     * Competition information and organizer details (FR-68, FR-70).
     *
     * Sections map onto the public pages: the home and about pages read
     * overview/purpose/benefits, the rules page reads the eligibility group,
     * and the organizer page reads the organizer group.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('section')
                ->options(CompetitionInformationModel::SECTIONS)
                ->required()
                ->native(false)
                ->helperText('Determines which public page shows this block.'),

            TextInput::make('title')
                ->required()
                ->maxLength(255),

            Textarea::make('body')
                ->required()
                ->rows(6)
                ->columnSpanFull()
                ->helperText('Put each bullet point on its own line; the first line is used as the lead.'),

            TextInput::make('sort_order')
                ->numeric()
                ->minValue(0)
                ->default(0),

            Toggle::make('is_published')
                ->label('Published')
                ->default(true),
        ]);
    }
}
