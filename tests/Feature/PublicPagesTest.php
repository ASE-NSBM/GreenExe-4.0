<?php

namespace Tests\Feature;

use Database\Seeders\CompetitionInformationSeeder;
use Database\Seeders\FaqSeeder;
use Database\Seeders\SmartCityContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public static function pageProvider(): array
    {
        return [
            ['home'],
            ['about'],
            ['smart-city'],
            ['competition'],
            ['rules'],
            ['faq'],
            ['organizer'],
            ['contact'],
            ['register'],
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_public_pages_render(string $route): void
    {
        $this->seed([
            SmartCityContentSeeder::class,
            CompetitionInformationSeeder::class,
            FaqSeeder::class,
        ]);

        $this->get(route($route))->assertOk();
    }

    public function test_home_page_shows_the_smart_green_city_concept(): void
    {
        $this->seed(SmartCityContentSeeder::class);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Smart Green City')
            ->assertSee('Register Now')
            ->assertSee('Smart energy and efficient resource use');
    }
}
