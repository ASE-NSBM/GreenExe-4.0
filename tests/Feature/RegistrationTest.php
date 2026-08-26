<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(int $members = 2): array
    {
        $payload = [
            'team_name' => 'Green Circuit',
            'member_count' => $members,
            'project_title' => 'Adaptive campus lighting',
            'project_category' => 'smart-energy',
            'project_description' => str_repeat('A smart lighting grid that dims when no one is nearby. ', 3),
            'problem_statement' => 'Campus lighting runs at full power all night and wastes energy.',
            'proposed_solution' => 'Motion and daylight sensors drive per-zone dimming through a mesh network.',
            'technology_used' => 'Laravel, ESP32, LoRa, PostgreSQL',
            'innovation_description' => 'Zone-level prediction instead of simple motion triggers, tuned per building.',
            'expected_impact' => 'Cuts outdoor lighting energy use substantially without reducing safety.',
            'declaration' => '1',
            'members' => [],
        ];

        for ($i = 0; $i < $members; $i++) {
            $payload['members'][] = [
                'full_name' => "Member {$i} Perera",
                'student_id' => "NSBM00{$i}",
                'email' => "member{$i}@students.nsbm.ac.lk",
                'contact_number' => '077123456'.$i,
                'whatsapp_number' => '077123456'.$i,
                'institution' => 'NSBM Green University',
            ];
        }

        return $payload;
    }

    public function test_registration_form_is_reachable(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Team &amp; Project Registration', false);
    }

    public function test_valid_registration_is_stored_and_confirmed(): void
    {
        $response = $this->post(route('register.store'), $this->validPayload());

        $response->assertRedirect(route('registration.success'));

        $registration = Registration::firstOrFail();
        $this->assertSame('Green Circuit', $registration->team_name);
        $this->assertCount(2, $registration->members);
        $this->assertTrue($registration->members->first()->is_leader);
        $this->assertMatchesRegularExpression('/^GX4-\d{2}-[A-Z0-9]{6}$/', $registration->registration_code);

        $this->get(route('registration.success'))
            ->assertOk()
            ->assertSee($registration->registration_code);
    }

    public function test_incomplete_submission_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['team_name'] = '';
        $payload['members'][0]['email'] = 'not-an-email';

        $this->post(route('register.store'), $payload)
            ->assertSessionHasErrors(['team_name', 'members.0.email'])
            ->followRedirects()
            ->assertSee('The email field must be a valid email address.')
            ->assertDontSee('members.0');

        $this->assertSame(0, Registration::count());
    }

    public function test_invalid_phone_numbers_are_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['members'][0]['contact_number'] = '+94771234567';
        $payload['members'][0]['whatsapp_number'] = '077123456';

        $this->post(route('register.store'), $payload)
            ->assertSessionHasErrors([
                'members.0.contact_number',
                'members.0.whatsapp_number',
            ]);

        $this->assertSame(0, Registration::count());
    }

    public function test_declaration_must_be_accepted(): void
    {
        $payload = $this->validPayload();
        unset($payload['declaration']);

        $this->post(route('register.store'), $payload)->assertSessionHasErrors('declaration');
        $this->assertSame(0, Registration::count());
    }

    public function test_duplicate_student_id_within_a_team_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['members'][1]['student_id'] = $payload['members'][0]['student_id'];

        $this->post(route('register.store'), $payload)->assertSessionHasErrors('members.1.student_id');
        $this->assertSame(0, Registration::count());
    }

    public function test_student_id_already_registered_is_rejected(): void
    {
        $this->post(route('register.store'), $this->validPayload())
            ->assertRedirect(route('registration.success'));

        $this->assertSame(2, TeamMember::count());

        $second = $this->validPayload();
        $second['team_name'] = 'Second Team';

        $this->post(route('register.store'), $second)
            ->assertSessionHasErrors('members.0.student_id');

        $this->assertSame(1, Registration::count());
    }

    public function test_extra_members_beyond_the_selected_count_are_ignored(): void
    {
        $payload = $this->validPayload(3);
        $payload['member_count'] = 2;

        $this->post(route('register.store'), $payload)->assertRedirect(route('registration.success'));

        $this->assertSame(2, TeamMember::count());
    }

    public function test_confirmation_requires_a_registration_in_the_session(): void
    {
        $this->get(route('registration.success'))->assertRedirect(route('register'));
    }
}
