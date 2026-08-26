<?php

namespace Tests\Feature;

use App\Filament\Resources\CompetitionInformation\Pages\ListCompetitionInformation;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Filament\Resources\Registrations\Pages\ListRegistrations;
use App\Filament\Resources\Registrations\Pages\ViewRegistration;
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
            'project_description' => 'A dashboard for campus energy.',
            'problem_statement' => 'Energy use is invisible.',
            'proposed_solution' => 'Meter every block.',
            'technology_used' => 'Laravel',
            'innovation_description' => 'Live feedback loops.',
            'expected_impact' => 'Lower consumption.',
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
            ->assertSee('Ada Perera')
            ->assertSee('ada@students.nsbm.ac.lk')
            ->assertSee('Energy use is invisible.');
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
