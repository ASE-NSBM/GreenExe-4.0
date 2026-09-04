<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_includes_canonical_social_and_structured_data(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('rel="canonical"', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('https://schema.org', false);
    }

    public function test_sitemap_lists_the_public_pages(): void
    {
        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee(route('home'), false)
            ->assertSee(route('register'), false)
            ->assertSee(route('faq'), false);
    }
}
