<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClosingPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_video_sources_and_poster_exist_on_disk(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        foreach ([
            'assets/video/ready-to-compete.webm',
            'assets/video/ready-to-compete.mp4',
            'assets/video/ready-to-compete-poster.jpg',
        ] as $asset) {
            $response->assertSee($asset, false);
            $this->assertFileExists(public_path($asset));
        }
    }

    public function test_registration_window_drives_the_panel_copy(): void
    {
        config(['greenexe.registration.open' => true]);
        $this->get('/')->assertSee('Registration open', false);

        config(['greenexe.registration.open' => false]);
        $this->get('/')->assertSee('Registration closed', false);
    }

    public function test_closing_date_is_shown_when_configured(): void
    {
        config(['greenexe.registration.closes_at' => '2026-09-30']);
        $this->get('/')->assertSee('Entries close on 30 September 2026', false);

        config(['greenexe.registration.closes_at' => null]);
        $this->get('/')->assertDontSee('Entries close on', false);
    }
}
