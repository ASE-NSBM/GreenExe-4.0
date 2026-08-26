<?php

namespace App\Filament\Resources\SmartCityContents\Tables;

use App\Models\SmartCityContent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SmartCityContentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultGroup('section')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('icon')->label('')->alignCenter(),
                TextColumn::make('section')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => SmartCityContent::SECTIONS[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('title')->searchable()->wrap(),
                TextColumn::make('description')->searchable()->limit(70)->toggleable(),
                TextColumn::make('sort_order')->label('#')->alignCenter()->sortable(),
                IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->filters([
                SelectFilter::make('section')->options(SmartCityContent::SECTIONS)->multiple(),
                TernaryFilter::make('is_published')->label('Published'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
