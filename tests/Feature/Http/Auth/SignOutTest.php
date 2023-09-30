<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignOutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the sign out functionality.
     */
    public function test_sign_out(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Log in the user
        auth()->login($user);

        // Assert that the user is authenticated
        $this->assertAuthenticatedAs($user);

        // Send a GET request to the sign-out route
        $response = $this->get(route('sign-out'));

        // Assert that the response redirects to the sign-in route
        $response->assertRedirectToRoute('sign-in');

        // Assert that the user is now a guest
        $this->assertGuest();
    }

    /**
     * Test that an unauthorized user cannot perform the sign out action.
     */
    public function test_unauthorized_cant_do_sign_out(): void
    {
        // Ensure that the user is not authenticated
        $this->assertGuest();

        // Send a GET request to the sign-out route
        $response = $this->get(route('sign-out'));

        // Assert that the response redirects to the sign-in route
        $response->assertRedirectToRoute('sign-in');
    }
}
