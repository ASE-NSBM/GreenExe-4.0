<?php

namespace Tests\Feature;

use App\Models\CompetitionInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePanelTwoTest extends TestCase
{
    use RefreshDatabase;

    public function test_panel_two_falls_back_when_unseeded(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        foreach ([
            'Overview', 'Competition overview',
            'Purpose', 'Purpose and objectives',
            'Benefits', 'Participant benefits',
            'Industry exposure and mentorship',
            'Networking with the ASE community and partners',
        ] as $needle) {
            $response->assertSee($needle, false);
        }
    }

    public function test_panel_two_reads_dashboard_content(): void
    {
        CompetitionInformation::create([
            'section' => 'overview',
            'title' => 'Edited overview title',
            'body' => 'Edited overview body.',
            'sort_order' => 0,
            'is_published' => true,
        ]);

        CompetitionInformation::create([
            'section' => 'benefits',
            'title' => 'Edited benefits',
            'body' => "First benefit\nSecond benefit",
            'sort_order' => 0,
            'is_published' => true,
        ]);

        $response = $this->get('/');

        $response->assertSee('Edited overview title', false);
        $response->assertSee('Edited overview body.', false);
        $response->assertSee('First benefit', false);
        $response->assertSee('Second benefit', false);
        $response->assertDontSee('Competition overview', false);
    }

    public function test_unpublished_sections_use_the_fallback(): void
    {
        CompetitionInformation::create([
            'section' => 'purpose',
            'title' => 'Hidden purpose',
            'body' => 'Hidden body.',
            'sort_order' => 0,
            'is_published' => false,
        ]);

        $response = $this->get('/');

        $response->assertDontSee('Hidden purpose', false);
        $response->assertSee('Purpose and objectives', false);
    }
}
