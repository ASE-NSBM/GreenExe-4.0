<?php

namespace Tests\Feature;

use App\Filament\Resources\CompetitionInformation\Pages\ListCompetitionInformation;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Filament\Resources\Registrations\Pages\EditRegistration;
use App\Filament\Resources\Registrations\Pages\ListRegistrations;
use App\Filament\Resources\Registrations\Pages\ViewRegistration;
use App\Filament\Resources\Registrations\RelationManagers\MembersRelationManager;
use App\Filament\Resources\SmartCityContents\Pages\ListSmartCityContents;
use App\Filament\Widgets\RegistrationStatsWidget;
use App\Models\Faq;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private ?User $admin = null;

    private function admin(): User
    {
        return $this->admin ??= User::create([
            'name' => 'Organiser',
            'email' => 'organiser@greenexe.local',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);
    }

    private function registration(array $attributes = []): Registration
    {
        $registration = Registration::create(array_merge([
            'registration_code' => Registration::generateCode(),
            'team_name' => 'Solar Foxes',
            'member_count' => 2,
            'project_title' => 'Campus energy dashboard',
            'project_category' => 'smart-energy',
            // Long enough to satisfy the same minimums the public form applies.
            'project_description' => 'A dashboard that meters every block on campus and publishes the readings.',
            'problem_statement' => 'Energy use across the campus is invisible today.',
            'proposed_solution' => 'Meter every block and publish the readings live.',
            'technology_used' => 'Laravel, PostgreSQL, ESP32',
            'innovation_description' => 'Live per-block feedback loops for occupants.',
            'expected_impact' => 'Lower consumption across the whole campus.',
            'status' => 'pending',
        ], $attributes));

        $registration->members()->create([
            'is_leader' => true,
            'full_name' => 'Ada Perera',
            'student_id' => 'ST0001',
            'email' => 'ada@students.nsbm.ac.lk',
            'contact_number' => '0771234567',
            'whatsapp_number' => '0771234567',
            'institution' => 'NSBM Green University',
        ]);

        return $registration;
    }

    /** FR-56, FR-71 */
    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));
        $this->get(route('filament.admin.auth.login'))->assertOk();
    }

    /** FR-71 */
    public function test_non_admin_accounts_cannot_reach_the_panel(): void
    {
        $participant = User::create([
            'name' => 'Participant',
            'email' => 'participant@example.com',
            'password' => 'password',
            'role' => 'participant',
        ]);

        $this->actingAs($participant)->get('/admin')->assertForbidden();
    }

    /** FR-58 */
    public function test_an_administrator_sees_the_dashboard_summary(): void
    {
        $this->registration();
        $this->registration(['team_name' => 'Wind Owls', 'status' => 'approved']);

        $this->actingAs($this->admin())->get('/admin')->assertOk();

        Livewire::actingAs($this->admin())
            ->test(RegistrationStatsWidget::class)
            ->assertSee('Teams registered')
            ->assertSee('Awaiting review');
    }

    /** FR-59, FR-60 */
    public function test_registrations_can_be_listed_and_searched(): void
    {
        $solar = $this->registration();
        $wind = $this->registration(['team_name' => 'Wind Owls', 'project_title' => 'Turbine monitor']);

        Livewire::actingAs($this->admin())
            ->test(ListRegistrations::class)
            ->assertCanSeeTableRecords([$solar, $wind])
            ->searchTable('Wind Owls')
            ->assertCanSeeTableRecords([$wind])
            ->assertCanNotSeeTableRecords([$solar])
            // FR-60 includes finding a team by a member's details.
            ->searchTable('ST0001')
            ->assertCanSeeTableRecords([$solar, $wind]);
    }

    /** FR-61 */
    public function test_registrations_can_be_filtered_by_status(): void
    {
        $pending = $this->registration();
        $approved = $this->registration(['team_name' => 'Wind Owls', 'status' => 'approved']);

        Livewire::actingAs($this->admin())
            ->test(ListRegistrations::class)
            ->filterTable('status', ['approved'])
            ->assertCanSeeTableRecords([$approved])
            ->assertCanNotSeeTableRecords([$pending]);
    }

    /** FR-62, FR-63 */
    public function test_the_view_page_shows_full_team_and_project_information(): void
    {
        $registration = $this->registration();

        Livewire::actingAs($this->admin())
            ->test(ViewRegistration::class, ['record' => $registration->getKey()])
            ->assertSee('Solar Foxes')
            ->assertSee('Campus energy dashboard')
            ->assertSee('Energy use across the campus is invisible today.');
    }

    /** FR-62: members are listed and each one can be opened on its own. */
    public function test_members_are_listed_and_can_be_viewed_individually(): void
    {
        $registration = $this->registration();
        $member = $registration->members()->first();

        Livewire::actingAs($this->admin())
            ->test(MembersRelationManager::class, [
                'ownerRecord' => $registration,
                'pageClass' => ViewRegistration::class,
            ])
            ->assertCanSeeTableRecords([$member])
            ->assertSee('Ada Perera')
            ->assertSee('ada@students.nsbm.ac.lk')
            ->callTableAction('view', $member)
            ->assertSuccessful();
    }

    /** FR-62: a member's own details can be corrected. */
    public function test_an_administrator_can_edit_a_member(): void
    {
        $registration = $this->registration();
        $member = $registration->members()->first();

        Livewire::actingAs($this->admin())
            ->test(MembersRelationManager::class, [
                'ownerRecord' => $registration,
                'pageClass' => EditRegistration::class,
            ])
            ->callTableAction('edit', $member, [
                'full_name' => 'Ada M. Perera',
                'student_id' => 'ST0009',
                'email' => 'ada.m@students.nsbm.ac.lk',
                'institution' => 'NSBM Green University',
                'contact_number' => '0777654321',
                'whatsapp_number' => '0777654321',
                'is_leader' => true,
            ])
            ->assertHasNoTableActionErrors();

        $member->refresh();

        $this->assertSame('Ada M. Perera', $member->full_name);
        $this->assertSame('ST0009', $member->student_id);
        $this->assertSame('ada.m@students.nsbm.ac.lk', $member->email);
    }

    /** A member's student ID stays unique across the competition. */
    public function test_a_member_cannot_take_another_teams_student_id(): void
    {
        $registration = $this->registration();
        $other = $this->registration(['team_name' => 'Wind Owls']);
        $other->members()->first()->update(['student_id' => 'ST9999']);

        $member = $registration->members()->first();

        Livewire::actingAs($this->admin())
            ->test(MembersRelationManager::class, [
                'ownerRecord' => $registration,
                'pageClass' => EditRegistration::class,
            ])
            ->callTableAction('edit', $member, [
                'full_name' => $member->full_name,
                'student_id' => 'ST9999',
                'email' => $member->email,
                'institution' => $member->institution,
                'contact_number' => $member->contact_number,
                'whatsapp_number' => $member->whatsapp_number,
            ])
            ->assertHasTableActionErrors(['student_id']);

        $this->assertSame('ST0001', $member->fresh()->student_id);
    }

    /** member_count is stored, so it has to follow the member list. */
    public function test_adding_and_removing_members_keeps_the_team_size_in_step(): void
    {
        $registration = $this->registration();
        $this->assertSame(2, $registration->member_count);

        $manager = Livewire::actingAs($this->admin())
            ->test(MembersRelationManager::class, [
                'ownerRecord' => $registration,
                'pageClass' => EditRegistration::class,
            ]);

        $manager->callTableAction('create', data: [
            'full_name' => 'Nimal Silva',
            'student_id' => 'ST0002',
            'email' => 'nimal@students.nsbm.ac.lk',
            'institution' => 'NSBM Green University',
            'contact_number' => '0771111111',
            'whatsapp_number' => '0771111111',
        ])->assertHasNoTableActionErrors();

        $this->assertSame(2, $registration->fresh()->member_count);
        $this->assertDatabaseCount('team_members', 2);

        $manager->callTableAction('delete', $registration->members()->where('student_id', 'ST0002')->first());

        $this->assertSame(1, $registration->fresh()->member_count);
    }

    /** A team has exactly one leader. */
    public function test_promoting_a_member_demotes_the_previous_leader(): void
    {
        $registration = $this->registration();
        $leader = $registration->members()->first();

        $second = $registration->members()->create([
            'is_leader' => false,
            'full_name' => 'Nimal Silva',
            'student_id' => 'ST0002',
            'email' => 'nimal@students.nsbm.ac.lk',
            'contact_number' => '0771111111',
            'whatsapp_number' => '0771111111',
            'institution' => 'NSBM Green University',
        ]);

        Livewire::actingAs($this->admin())
            ->test(MembersRelationManager::class, [
                'ownerRecord' => $registration,
                'pageClass' => EditRegistration::class,
            ])
            ->callTableAction('edit', $second, [
                'full_name' => $second->full_name,
                'student_id' => $second->student_id,
                'email' => $second->email,
                'institution' => $second->institution,
                'contact_number' => $second->contact_number,
                'whatsapp_number' => $second->whatsapp_number,
                'is_leader' => true,
            ])
            ->assertHasNoTableActionErrors();

        $this->assertTrue($second->fresh()->is_leader);
        $this->assertFalse($leader->fresh()->is_leader);
    }

    /** FR-62, FR-63: team and project details are editable. */
    public function test_an_administrator_can_edit_team_and_project_details(): void
    {
        $registration = $this->registration();

        Livewire::actingAs($this->admin())
            ->test(EditRegistration::class, ['record' => $registration->getKey()])
            ->fillForm([
                'team_name' => 'Solar Foxes Renamed',
                'project_title' => 'Campus energy dashboard v2',
                'project_category' => 'smart-buildings',
                'status' => 'reviewed',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $registration->refresh();

        $this->assertSame('Solar Foxes Renamed', $registration->team_name);
        $this->assertSame('Campus energy dashboard v2', $registration->project_title);
        $this->assertSame('smart-buildings', $registration->project_category);
        $this->assertSame('reviewed', $registration->status);
    }

    /** FR-64 */
    public function test_an_administrator_can_update_a_registration_status(): void
    {
        $registration = $this->registration();

        Livewire::actingAs($this->admin())
            ->test(ListRegistrations::class)
            ->callTableAction('updateStatus', $registration, ['status' => 'approved']);

        $this->assertSame('approved', $registration->fresh()->status);
    }

    /** FR-65 */
    public function test_an_administrator_can_archive_or_delete_a_registration(): void
    {
        $archived = $this->registration();
        $deleted = $this->registration(['team_name' => 'Wind Owls']);

        Livewire::actingAs($this->admin())
            ->test(ListRegistrations::class)
            ->callTableAction('archive', $archived)
            ->callTableAction('delete', $deleted);

        $this->assertSame('archived', $archived->fresh()->status);
        $this->assertNull($deleted->fresh());
        $this->assertDatabaseCount('team_members', 1);
    }

    /** FR-66 */
    public function test_registrations_export_as_csv(): void
    {
        $this->registration();

        $response = $this->actingAs($this->admin())->get(route('admin.registrations.export'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $csv = $response->streamedContent();

        $this->assertStringContainsString('registration_code,team_name', $csv);
        $this->assertStringContainsString('Solar Foxes', $csv);
        $this->assertStringContainsString('leader', $csv);
        $this->assertStringContainsString('ada@students.nsbm.ac.lk', $csv);
    }

    /** FR-66, FR-71 */
    public function test_the_export_is_not_reachable_without_an_admin_account(): void
    {
        $this->get(route('admin.registrations.export'))->assertRedirect();

        $participant = User::create([
            'name' => 'Participant',
            'email' => 'participant@example.com',
            'password' => 'password',
            'role' => 'participant',
        ]);

        $this->actingAs($participant)->get(route('admin.registrations.export'))->assertForbidden();
    }

    /** FR-67 */
    public function test_faqs_can_be_managed(): void
    {
        $faq = Faq::create([
            'question' => 'Who can enter?',
            'answer' => 'Any registered student team.',
            'sort_order' => 0,
            'is_published' => true,
        ]);

        Livewire::actingAs($this->admin())
            ->test(ListFaqs::class)
            ->assertCanSeeTableRecords([$faq])
            ->callTableAction('delete', $faq);

        $this->assertDatabaseCount('faqs', 0);
    }

    /** FR-68, FR-69, FR-70 */
    public function test_content_resources_are_reachable(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/competition-information')->assertOk();
        $this->actingAs($admin)->get('/admin/smart-city-contents')->assertOk();

        Livewire::actingAs($admin)->test(ListCompetitionInformation::class)->assertOk();
        Livewire::actingAs($admin)->test(ListSmartCityContents::class)->assertOk();
    }

    /** SRS 7.1 documents these paths; Filament serves them under other URLs. */
    public function test_the_documented_admin_paths_still_resolve(): void
    {
        $this->actingAs($this->admin());

        $this->get('/admin/dashboard')->assertRedirect('/admin');
        $this->get('/admin/content')->assertRedirect('/admin/competition-information');
    }
}
