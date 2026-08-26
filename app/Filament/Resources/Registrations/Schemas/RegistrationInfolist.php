<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
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

                    RepeatableEntry::make('members')
                        ->columnSpanFull()
                        ->columns(3)
                        ->schema([
                            TextEntry::make('full_name')
                                ->label('Name')
                                ->badge()
                                ->color(fn ($record) => $record->is_leader ? 'success' : 'gray')
                                ->formatStateUsing(fn ($state, $record) => $record->is_leader ? "{$state} (team leader)" : $state),
                            TextEntry::make('student_id')->label('Student ID'),
                            TextEntry::make('institution'),
                            TextEntry::make('email')->copyable(),
                            TextEntry::make('contact_number')->label('Contact'),
                            TextEntry::make('whatsapp_number')->label('WhatsApp'),
                        ]),
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
                ]),
        ]);
    }
}
