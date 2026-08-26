<?php

namespace App\Filament\Resources\Registrations\Tables;

use App\Filament\Resources\Registrations\RegistrationResource;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RegistrationsTable
{
    /**
     * Registration list with search, filters and per-row management actions
     * (FR-59 to FR-61, FR-64, FR-65).
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('registration_code')
                    ->label('Reference')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium'),

                TextColumn::make('team_name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('project_title')
                    ->label('Project')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn (Registration $record) => $record->project_title),

                // Searching the members relationship covers FR-60's requirement
                // to find a team by a member's name, email or student ID.
                TextColumn::make('members.full_name')
                    ->label('Members')
                    ->searchable()
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->toggleable(),

                TextColumn::make('members.email')
                    ->label('Emails')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('members.student_id')
                    ->label('Student IDs')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('member_count')
                    ->label('Size')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('project_category')
                    ->label('Category')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => config("greenexe.categories.{$state}") ?? '—')
                    ->toggleable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state) => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'reviewed' => 'info',
                        'archived' => 'gray',
                        default => 'warning',
                    }),

                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('j M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(array_combine(Registration::STATUSES, array_map('ucfirst', Registration::STATUSES)))
                    ->multiple(),

                SelectFilter::make('project_category')
                    ->label('Category')
                    ->options(config('greenexe.categories'))
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // FR-64: status is the only field an administrator edits.
                Action::make('updateStatus')
                    ->label('Set status')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Select::make('status')
                            ->options(array_combine(Registration::STATUSES, array_map('ucfirst', Registration::STATUSES)))
                            ->required(),
                    ])
                    ->fillForm(fn (Registration $record) => ['status' => $record->status])
                    ->action(fn (Registration $record, array $data) => $record->update($data))
                    ->successNotificationTitle('Registration status updated.'),

                // FR-65: archiving is the reversible half of "delete or archive".
                Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record) => $record->status !== 'archived')
                    ->action(fn (Registration $record) => $record->update(['status' => 'archived']))
                    ->successNotificationTitle('Registration archived.'),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            // Clicking a row opens the full team and project detail.
            ->recordUrl(fn (Model $record) => RegistrationResource::getUrl('view', ['record' => $record]));
    }
}
