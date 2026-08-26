<?php

namespace App\Filament\Resources\SmartCityContents\Schemas;

use App\Models\SmartCityContent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SmartCityContentForm
{
    /** Smart Green City content (FR-69). */
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('section')
                ->options(SmartCityContent::SECTIONS)
                ->required()
                ->native(false)
                ->helperText('Pillars and highlights share their copy; highlights also drive the home-page carousel.'),

            TextInput::make('title')->required()->maxLength(255),

            TextInput::make('icon')
                ->maxLength(16)
                ->helperText('A single emoji, shown when a pillar has no artwork.'),

            Textarea::make('description')
                ->required()
                ->rows(6)
                ->columnSpanFull()
                ->helperText('First line is the lead sentence; each following line becomes a bullet point.'),

            TextInput::make('sort_order')->numeric()->minValue(0)->default(0),

            Toggle::make('is_published')->label('Published')->default(true),
        ]);
    }
}
