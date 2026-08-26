<?php

namespace App\Filament\Resources\CompetitionInformation\Tables;

use App\Models\CompetitionInformation as CompetitionInformationModel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CompetitionInformationTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultGroup('section')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('section')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => CompetitionInformationModel::SECTIONS[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('title')->searchable()->wrap(),
                TextColumn::make('body')->searchable()->limit(70)->toggleable(),
                TextColumn::make('sort_order')->label('#')->alignCenter()->sortable(),
                IconColumn::make('is_published')->label('Published')->boolean(),
                TextColumn::make('updated_at')->label('Updated')->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('section')->options(CompetitionInformationModel::SECTIONS)->multiple(),
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
