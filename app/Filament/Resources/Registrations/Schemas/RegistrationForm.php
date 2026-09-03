<?php

namespace App\Filament\Resources\Registrations\Schemas;

use App\Models\Registration;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class RegistrationForm
{
    /**
     * Team, project and status details (FR-62 to FR-64).
     *
     * Field rules mirror StoreRegistrationRequest so a correction made in the
     * dashboard cannot store something the public form would have rejected.
     * Team members are edited through the relation manager below the form.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Review')
                ->description('The reference is generated at submission and cannot be changed.')
                ->columns(3)
                ->schema([
                    TextInput::make('registration_code')
                        ->label('Reference')
                        ->disabled()
                        ->dehydrated(false),

                    Select::make('status')
                        ->options(array_combine(Registration::STATUSES, array_map('ucfirst', Registration::STATUSES)))
                        ->required()
                        ->native(false),

                    TextInput::make('member_count')
                        ->label('Team size')
                        ->disabled()
                        ->dehydrated(false)
                        ->helperText('Follows the member list.'),
                ]),

            Section::make('Team')
                ->schema([
                    TextInput::make('team_name')
                        ->label('Team name')
                        ->required()
                        ->minLength(3)
                        ->maxLength(120)
                        ->rule(fn (?Model $record) => Rule::unique('registrations', 'team_name')->ignore($record?->getKey())),
                ]),

            Section::make('Project')
                ->columns(2)
                ->schema([
                    TextInput::make('project_title')
                        ->label('Title')
                        ->required()
                        ->minLength(3)
                        ->maxLength(150),

                    Select::make('project_category')
                        ->label('Category')
                        ->options(config('greenexe.categories'))
                        ->native(false)
                        ->placeholder('Not set'),

                    Textarea::make('project_description')
                        ->label('Description')
                        ->required()
                        ->minLength(50)
                        ->maxLength(2000)
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('problem_statement')
                        ->label('Problem statement')
                        ->required()
                        ->minLength(30)
                        ->maxLength(2000)
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('proposed_solution')
                        ->label('Proposed solution')
                        ->required()
                        ->minLength(30)
                        ->maxLength(2000)
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('technology_used')
                        ->label('Technology used')
                        ->required()
                        ->minLength(3)
                        ->maxLength(1000)
                        ->rows(2)
                        ->columnSpanFull(),

                    Textarea::make('innovation_description')
                        ->label('Innovation')
                        ->required()
                        ->minLength(30)
                        ->maxLength(2000)
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('expected_impact')
                        ->label('Expected impact')
                        ->required()
                        ->minLength(30)
                        ->maxLength(2000)
                        ->rows(3)
                        ->columnSpanFull(),

                    Toggle::make('has_previous_hackathon_experience')
                        ->label('Previously entered in another hackathon?')
                        ->helperText('Turn on for Yes; leave off for No.'),

                    Textarea::make('previous_hackathon_details')
                        ->label('Previous participation, placements, awards or wins')
                        ->helperText('Include the event, year, placement, award, win, or other result.')
                        ->maxLength(1000)
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
