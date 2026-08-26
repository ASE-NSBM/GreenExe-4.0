<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberStepperTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_form_renders_a_card_per_possible_member_with_stepper_controls(): void
    {
        $max = (int) config('greenexe.team.max_members');

        $response = $this->get(route('register'));
        $response->assertOk();

        $html = $response->getContent();

        $this->assertSame($max, substr_count($html, 'data-member-card'));
        $this->assertStringContainsString('data-member-next', $html);
        $this->assertStringContainsString('data-member-prev', $html);
        $this->assertStringContainsString('data-member-progress-bar', $html);

        // Without JavaScript the stepper is hidden and every card stays visible.
        $this->assertStringContainsString('hidden flex-wrap items-center gap-3" data-member-nav', $html);
    }

    public function test_a_member_card_is_marked_when_its_fields_fail_validation(): void
    {
        $response = $this->from(route('register'))->followingRedirects()->post(route('register.store'), [
            'team_name' => 'Marker Team',
            'member_count' => 2,
            'members' => [
                ['full_name' => 'Ada Perera', 'student_id' => 'ST1', 'email' => 'ada@nsbm.ac.lk', 'contact_number' => '0771234567', 'whatsapp_number' => '0771234567', 'institution' => 'NSBM'],
                // Second member is left empty, so only its card should be flagged.
                ['full_name' => '', 'student_id' => '', 'email' => '', 'contact_number' => '', 'whatsapp_number' => '', 'institution' => ''],
            ],
            'project_title' => 'Campus energy dashboard',
            'project_description' => str_repeat('An energy dashboard for the campus. ', 3),
            'problem_statement' => str_repeat('Energy use is invisible today. ', 2),
            'proposed_solution' => str_repeat('Meter every block and publish it. ', 2),
            'technology_used' => 'Laravel',
            'innovation_description' => str_repeat('Live per-block feedback loops. ', 2),
            'expected_impact' => str_repeat('Lower consumption across campus. ', 2),
            'declaration' => '1',
        ]);

        $response->assertOk();

        $html = $response->getContent();

        // The failing card carries the marker the stepper opens on. Blade leaves
        // whitespace around the conditional attribute, so match loosely.
        $this->assertMatchesRegularExpression('/data-member-index="1"\s+data-member-error/', $html);
        $this->assertDoesNotMatchRegularExpression('/data-member-index="0"\s+data-member-error/', $html);
    }
}
