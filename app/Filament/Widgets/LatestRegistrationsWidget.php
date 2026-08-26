<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Registrations\RegistrationResource;
use App\Models\Registration;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestRegistrationsWidget extends TableWidget
{
    /** The most recent submissions, part of the dashboard summary (FR-58). */
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest submissions')
            ->query(fn (): Builder => Registration::query()->with('members')->latest()->limit(8))
            ->paginated(false)
            ->columns([
                TextColumn::make('registration_code')->label('Reference'),
                TextColumn::make('team_name')->label('Team'),
                TextColumn::make('project_title')->label('Project')->limit(40),
                TextColumn::make('member_count')->label('Size')->alignCenter(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'reviewed' => 'info',
                        'archived' => 'gray',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')->label('Submitted')->since(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Registration $record) => RegistrationResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
