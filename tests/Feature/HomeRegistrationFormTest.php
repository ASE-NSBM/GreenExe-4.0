<?php

namespace Tests\Feature;

use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeRegistrationFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_form_is_embedded_in_the_closing_panel(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertSee('action="'.route('register.store').'"', false);
        $response->assertSee('data-registration-form', false);
        $response->assertSee('Team leader', false);
        $response->assertSee('name="members[0][full_name]"', false);
    }

    public function test_the_form_is_replaced_by_a_notice_when_registration_is_closed(): void
    {
        config(['greenexe.registration.open' => false]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Registration is closed', false);
        $response->assertDontSee('data-registration-form', false);
    }

    public function test_a_team_can_register_from_the_home_page(): void
    {
        $response = $this->from('/')->post(route('register.store'), $this->payload());

        $response->assertRedirect(route('registration.success'));

        $registration = Registration::with('members')->firstOrFail();

        $this->assertSame('Home Page Team', $registration->team_name);
        $this->assertTrue($registration->members->firstWhere('full_name', 'Ada Perera')->is_leader);
        $this->assertFalse($registration->members->firstWhere('full_name', 'Nimal Silva')->is_leader);
    }

    public function test_a_failed_submission_returns_to_the_home_page_with_errors(): void
    {
        $payload = $this->payload();
        $payload['team_name'] = '';

        $response = $this->from('/')->post(route('register.store'), $payload);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('team_name');
        $this->assertSame(0, Registration::count());
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(): array
    {
        $member = fn (string $name, string $id) => [
            'full_name' => $name,
            'student_id' => $id,
            'email' => str($name)->slug().'@students.nsbm.ac.lk',
            'contact_number' => '0771234567',
            'whatsapp_number' => '0771234567',
            'institution' => 'NSBM Green University',
        ];

        return [
            'team_name' => 'Home Page Team',
            'member_count' => 2,
            'members' => [$member('Ada Perera', 'ST0001'), $member('Nimal Silva', 'ST0002')],
            'project_title' => 'Campus energy dashboard',
            'project_category' => 'smart-energy',
            'project_description' => str_repeat('An energy dashboard for the campus. ', 3),
            'problem_statement' => str_repeat('Energy use is invisible today. ', 2),
            'proposed_solution' => str_repeat('Meter every block and publish it. ', 2),
            'technology_used' => 'Laravel, PostgreSQL, ESP32',
            'innovation_description' => str_repeat('Live per-block feedback loops. ', 2),
            'expected_impact' => str_repeat('Lower consumption across campus. ', 2),
            'declaration' => '1',
        ];
    }
}
