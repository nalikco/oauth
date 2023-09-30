<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This method tests the view of the sign-in page.
     */
    public function test_view(): void
    {
        // Send a GET request to the 'sign-in' route
        $response = $this->get(route('sign-in'));

        // Assert that the response has a 200 OK status code
        $response->assertOk();

        // Assert that the response body contains the translated text of the sign-in page title
        $response->assertSeeText(__('auth.sign_in.title'));
    }

    /**
     * Test that an authenticated user cannot view the sign-in page.
     */
    public function test_authenticated_cant_view(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a GET request to the sign-in route
        $response = $this->actingAs($user)->get(route('sign-in'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }

    /**
     * Test the handle method.
     *
     * This method tests the handle method of the class under test.
     * It creates a new user, signs in with the user's credentials,
     * and asserts that the user is authenticated and redirected to
     * the dashboard route.
     */
    public function test_handle(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Sign in with the user's credentials
        $response = $this->post(route('sign-in'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert that the user is authenticated
        $this->assertAuthenticatedAs($user);

        // Assert that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }

    /**
     * Test the failed in handle method.
     *
     * This method tests the handling of failed sign-in attempts by creating a new user
     * and attempting to sign in with different combinations of incorrect email and password.
     * It asserts that the response redirects to the sign-in route, and that the session
     * contains an error for the email field. Finally, it asserts that the user is still a guest.
     */
    public function test_handle_failed(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Define an array of test cases, each containing an email and password combination
        $testCases = [
            [
                'email' => $user->email,
                'password' => 'wrong',
            ], [
                'email' => 'wrong email format',
                'password' => 'password',
            ], [
                'email' => 'wrong@mail.com',
                'password' => 'password',
            ],
        ];

        // Iterate through each test case and perform the sign-in attempt
        foreach ($testCases as $case) {
            $response = $this->post(route('sign-in'), [
                'email' => $case['email'],
                'password' => $case['password'],
            ]);

            // Assert that the session contains an error for the email field
            $response->assertSessionHasErrors('email');

            // Assert that the response redirects
            $response->assertRedirect();

            // Assert that the user is still a guest
            $this->assertGuest();
        }
    }

    /**
     * Test that an authenticated user cannot be handled.
     */
    public function test_authenticated_cant_handle(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a POST request to the sign-in route
        $response = $this->actingAs($user)->post(route('sign-in'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }
}
