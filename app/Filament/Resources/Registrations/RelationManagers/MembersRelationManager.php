<?php

namespace App\Filament\Resources\Registrations\RelationManagers;

use App\Models\TeamMember;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Team members';

    protected static ?string $recordTitleAttribute = 'full_name';

    /**
     * Editing a member (FR-62). Uniqueness mirrors StoreRegistrationRequest:
     * a student ID or email may only appear once across the whole competition.
     */
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('full_name')
                        ->label('Full name')
                        ->required()
                        ->minLength(3)
                        ->maxLength(120),

                    TextInput::make('student_id')
                        ->label('Student ID')
                        ->required()
                        ->maxLength(40)
                        ->rule(fn (?Model $record) => Rule::unique('team_members', 'student_id')->ignore($record?->getKey())),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(150)
                        ->rule(fn (?Model $record) => Rule::unique('team_members', 'email')->ignore($record?->getKey())),

                    TextInput::make('institution')
                        ->required()
                        ->maxLength(150)
                        ->default(config('greenexe.event.university')),

                    TextInput::make('contact_number')
                        ->label('Contact number')
                        ->tel()
                        ->required()
                        ->regex('/^\+?[0-9][0-9\s\-]{6,19}$/')
                        ->helperText('For example 0771234567 or +94771234567.'),

                    TextInput::make('whatsapp_number')
                        ->label('WhatsApp number')
                        ->tel()
                        ->required()
                        ->regex('/^\+?[0-9][0-9\s\-]{6,19}$/'),

                    Toggle::make('is_leader')
                        ->label('Team leader')
                        ->helperText('A team has exactly one leader; promoting a member demotes the current one.'),
                ]),
        ]);
    }

    /** Full details for one member (FR-62). */
    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->columns(2)
                ->schema([
                    TextEntry::make('full_name')->label('Full name'),
                    TextEntry::make('is_leader')
                        ->label('Role')
                        ->badge()
                        ->formatStateUsing(fn (bool $state) => $state ? 'Team leader' : 'Member')
                        ->color(fn (bool $state) => $state ? 'success' : 'gray'),
                    TextEntry::make('student_id')->label('Student ID')->copyable(),
                    TextEntry::make('institution'),
                    TextEntry::make('email')->copyable(),
                    TextEntry::make('contact_number')->label('Contact number')->copyable(),
                    TextEntry::make('whatsapp_number')->label('WhatsApp number')->copyable(),
                    TextEntry::make('created_at')->label('Added')->dateTime('j M Y, H:i'),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->defaultSort('is_leader', 'desc')
            ->columns([
                IconColumn::make('is_leader')
                    ->label('Leader')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('full_name')->label('Name')->searchable()->sortable(),
                TextColumn::make('student_id')->label('Student ID')->searchable(),
                TextColumn::make('email')->searchable()->copyable(),
                TextColumn::make('contact_number')->label('Contact')->toggleable(),
                TextColumn::make('whatsapp_number')->label('WhatsApp')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('institution')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add member')
                    ->after(fn () => $this->syncMemberCount()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->after(fn (TeamMember $record) => $this->syncLeader($record)),
                DeleteAction::make()->after(fn () => $this->syncMemberCount()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->after(fn () => $this->syncMemberCount()),
                ]),
            ]);
    }

    /**
     * member_count is stored on the registration, so it has to follow whenever
     * the admin adds or removes someone.
     */
    protected function syncMemberCount(): void
    {
        $registration = $this->getOwnerRecord();

        $registration->update(['member_count' => $registration->members()->count()]);
    }

    /** Keep exactly one leader per team. */
    protected function syncLeader(TeamMember $member): void
    {
        if (! $member->is_leader) {
            return;
        }

        $this->getOwnerRecord()
            ->members()
            ->whereKeyNot($member->getKey())
            ->update(['is_leader' => false]);
    }
}
