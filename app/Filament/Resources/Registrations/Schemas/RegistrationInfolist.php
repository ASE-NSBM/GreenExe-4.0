<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationInfolist
{
    /**
     * Complete team and project information (FR-62, FR-63).
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Submission')
                ->columns(4)
                ->schema([
                    TextEntry::make('registration_code')->label('Reference')->copyable(),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state) => match ($state) {
                            'approved' => 'success',
                            'rejected' => 'danger',
                            'reviewed' => 'info',
                            'archived' => 'gray',
                            default => 'warning',
                        }),
                    TextEntry::make('created_at')->label('Submitted')->dateTime('j M Y, H:i'),
                    TextEntry::make('updated_at')->label('Last updated')->since(),
                ]),

            Section::make('Team')
                ->columns(2)
                ->schema([
                    TextEntry::make('team_name')->label('Team name'),
                    TextEntry::make('member_count')->label('Members'),
                    // The member list itself is the relation manager below.
                ]),

            Section::make('Project')
                ->columns(2)
                ->schema([
                    TextEntry::make('project_title')->label('Title'),
                    TextEntry::make('project_category')
                        ->label('Category')
                        ->formatStateUsing(fn (?string $state) => config("greenexe.categories.{$state}") ?? '—'),
                    TextEntry::make('project_description')->label('Description')->columnSpanFull(),
                    TextEntry::make('problem_statement')->label('Problem statement')->columnSpanFull(),
                    TextEntry::make('proposed_solution')->label('Proposed solution')->columnSpanFull(),
                    TextEntry::make('technology_used')->label('Technology used')->columnSpanFull(),
                    TextEntry::make('innovation_description')->label('Innovation')->columnSpanFull(),
                    TextEntry::make('expected_impact')->label('Expected impact')->columnSpanFull(),
                    TextEntry::make('has_previous_hackathon_experience')
                        ->label('Previous hackathon participation')
                        ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                        ->badge()
                        ->color(fn (bool $state): string => $state ? 'info' : 'gray'),
                    TextEntry::make('previous_hackathon_details')
                        ->label('Previous participation, placements, awards or wins')
                        ->placeholder('Not applicable')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
