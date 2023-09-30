<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Test the view of the dashboard.
     */
    public function test_view(): void
    {
        // Create a user using the User factory
        $user = User::factory()->create();

        // Act as the authenticated user and get the dashboard route
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Assert that the response status is OK
        $response->assertOk();

        // Assert that the response contains the expected texts in order
        $response->assertSeeTextInOrder([
            __('dashboard.page_title'),
            __('dashboard.no_authorized_applications'),
        ]);
    }
}
