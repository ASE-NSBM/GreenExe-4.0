<?php

namespace App\Filament\Resources\Registrations\Schemas;

use App\Models\Registration;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationForm
{
    /**
     * Administrators update the status only (FR-64). Team and project data is
     * owned by the participants who submitted it, so it is shown read-only on
     * the view page rather than made editable here.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Review')
                ->description('Only the status of a submission can be changed from the dashboard.')
                ->schema([
                    Select::make('status')
                        ->options(array_combine(Registration::STATUSES, array_map('ucfirst', Registration::STATUSES)))
                        ->required()
                        ->native(false),
                ]),
        ]);
    }
}
