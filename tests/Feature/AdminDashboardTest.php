<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@greenexe.test',
            'password' => Hash::make('secret-password'),
            'role' => User::ROLE_ADMIN,
        ]);
    }

    private function registration(array $overrides = []): Registration
    {
        $registration = Registration::create(array_merge([
            'registration_code' => Registration::generateCode(),
            'team_name' => 'Green Circuit',
            'member_count' => 2,
            'project_title' => 'Adaptive campus lighting',
            'project_category' => 'smart-energy',
            'project_description' => 'Description',
            'problem_statement' => 'Problem',
            'proposed_solution' => 'Solution',
            'technology_used' => 'Laravel',
            'innovation_description' => 'Innovation',
            'expected_impact' => 'Impact',
            'status' => 'pending',
        ], $overrides));

        $registration->members()->create([
            'is_leader' => true,
            'full_name' => 'Nadeesha Perera',
            'student_id' => 'NSBM001',
            'email' => 'nadeesha@students.nsbm.ac.lk',
            'contact_number' => '0771234567',
            'whatsapp_number' => '0771234567',
            'institution' => 'NSBM Green University',
        ]);

        return $registration;
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.registrations.index'))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_users_are_forbidden(): void
    {
        $user = User::create([
            'name' => 'Participant',
            'email' => 'participant@example.com',
            'password' => Hash::make('secret-password'),
            'role' => 'participant',
        ]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_log_in_and_see_the_dashboard(): void
    {
        $admin = $this->admin();

        $this->post(route('admin.login.attempt'), [
            'email' => $admin->email,
            'password' => 'secret-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Dashboard');
    }

    public function test_bad_credentials_are_rejected(): void
    {
        $admin = $this->admin();

        $this->post(route('admin.login.attempt'), [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_search_and_filter_registrations(): void
    {
        $admin = $this->admin();
        $this->registration();
        $this->registration(['team_name' => 'Solar Roots', 'status' => 'approved', 'project_category' => 'smart-mobility']);

        $this->actingAs($admin)
            ->get(route('admin.registrations.index', ['q' => 'Solar']))
            ->assertOk()
            ->assertSee('Solar Roots')
            ->assertDontSee('Green Circuit');

        $this->actingAs($admin)
            ->get(route('admin.registrations.index', ['status' => 'approved']))
            ->assertOk()
            ->assertSee('Solar Roots')
            ->assertDontSee('Green Circuit');
    }

    public function test_admin_can_update_status_archive_and_delete(): void
    {
        $admin = $this->admin();
        $registration = $this->registration();

        $this->actingAs($admin)
            ->patch(route('admin.registrations.update', $registration), ['status' => 'approved']);
        $this->assertSame('approved', $registration->fresh()->status);

        $this->actingAs($admin)
            ->delete(route('admin.registrations.destroy', $registration), ['mode' => 'archive']);
        $this->assertSame('archived', $registration->fresh()->status);

        $this->actingAs($admin)
            ->delete(route('admin.registrations.destroy', $registration), ['mode' => 'delete']);
        $this->assertSame(0, Registration::count());
    }

    public function test_admin_can_export_registrations_as_csv(): void
    {
        $admin = $this->admin();
        $registration = $this->registration();

        $response = $this->actingAs($admin)->get(route('admin.registrations.export'));
        $response->assertOk();
        $this->assertStringStartsWith('text/csv', $response->headers->get('content-type'));

        $csv = $response->streamedContent();
        $this->assertStringContainsString($registration->registration_code, $csv);
        $this->assertStringContainsString('nadeesha@students.nsbm.ac.lk', $csv);
    }

    public function test_admin_can_log_out(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
