<?php

namespace Tests\Feature;

use App\Models\SmartCityContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HighlightCarouselTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_highlight_becomes_a_slide_with_its_points(): void
    {
        SmartCityContent::create([
            'section' => 'highlight',
            'title' => 'Smart buildings and connected infrastructure',
            'description' => "Lead sentence.\nFirst point\nSecond point",
            'icon' => '🏢',
            'sort_order' => 0,
            'is_published' => true,
        ]);

        SmartCityContent::create([
            'section' => 'highlight',
            'title' => 'Environmental monitoring',
            'description' => 'Only a lead.',
            'icon' => '📡',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->get('/');
        $response->assertOk();

        $html = $response->getContent();

        $this->assertSame(2, substr_count($html, 'data-carousel-slide'));
        $this->assertStringContainsString('Lead sentence.', $html);
        $this->assertStringContainsString('First point', $html);
        $this->assertStringContainsString('Second point', $html);
        $this->assertStringContainsString('Only a lead.', $html);

        // The supplied artwork is matched to the first pillar; the second has
        // none and falls back to its gradient.
        $this->assertStringContainsString('assets/img/Smartbuildings.jpg', $html);
    }

    public function test_unpublished_highlights_are_not_shown(): void
    {
        SmartCityContent::create([
            'section' => 'highlight',
            'title' => 'Hidden pillar',
            'description' => 'Hidden lead.',
            'sort_order' => 0,
            'is_published' => false,
        ]);

        $response = $this->get('/');

        $response->assertDontSee('Hidden pillar', false);
        $this->assertSame(0, substr_count($response->getContent(), 'data-carousel-slide'));
    }
}
