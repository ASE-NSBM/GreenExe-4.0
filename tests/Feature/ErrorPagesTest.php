<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_unknown_url_returns_the_branded_404(): void
    {
        $response = $this->get('/no-such-page');

        $response->assertNotFound();
        $response->assertSee('took a wrong turn', false);
        $response->assertSee('Error 404', false);

        // The site chrome, so a wrong URL is still navigable.
        $response->assertSee('logo-bgremoved.png', false);
        $response->assertSee(route('home'), false);
    }

    /**
     * @return list<list<string>>
     */
    public static function errorCodeProvider(): array
    {
        return [['403'], ['404'], ['419'], ['429'], ['500'], ['503']];
    }

    #[DataProvider('errorCodeProvider')]
    public function test_each_error_view_renders(string $code): void
    {
        $html = view("errors.{$code}")->render();

        $this->assertStringContainsString('gx-error-code', $html);
        $this->assertStringContainsString(">{$code}<", $html);
        // Decorative numeral must stay out of the accessibility tree.
        $this->assertMatchesRegularExpression('/<span class="gx-error-code" aria-hidden="true">/', $html);
    }

    public function test_a_forbidden_admin_page_uses_the_branded_403(): void
    {
        $participant = User::create([
            'name' => 'Participant',
            'email' => 'participant@example.com',
            'password' => 'password',
            'role' => 'participant',
        ]);

        $response = $this->actingAs($participant)->get('/admin');

        $response->assertForbidden();
        $response->assertSee('access to this', false);
    }
}
