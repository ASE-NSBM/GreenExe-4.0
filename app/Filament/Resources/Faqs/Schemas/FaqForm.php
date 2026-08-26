<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    /** Manage FAQs (FR-55, FR-67). */
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('question')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('answer')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            TextInput::make('sort_order')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->helperText('Lower numbers appear first.'),

            Toggle::make('is_published')
                ->label('Published')
                ->default(true)
                ->helperText('Unpublished entries stay hidden on the public site.'),
        ]);
    }
}
