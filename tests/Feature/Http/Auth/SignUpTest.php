<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This method tests the view of the sign-up page.
     */
    public function test_view(): void
    {
        // Send a GET request to the 'sign-up' route
        $response = $this->get(route('sign-up'));

        // Assert that the response has a 200 OK status code
        $response->assertOk();

        // Assert that the response body contains the translated text of the sign-up page title
        $response->assertSeeText(__('auth.sign_up.title'));
    }

    /**
     * Test that an authenticated user cannot view the sign-up page.
     */
    public function test_authenticated_cant_view(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a GET request to the sign-up route
        $response = $this->actingAs($user)->get(route('sign-up'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }

    /**
     * Test the handle method.
     */
    public function test_handle(): void
    {
        // Send a POST request to the sign-up route with the required data
        $response = $this->post(route('sign-up'), [
            'name' => 'test',
            'email' => 'test@mail.com',
            'password' => 'password',
        ]);

        // Assert that the user is authenticated and logged in
        $this->assertAuthenticatedAs(User::query()->first());

        // Assert that the response redirects to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }

    /**
     * Test the validation handling of the sign-up API.
     */
    public function test_handle_validations(): void
    {
        // Create a user with an email for testing purposes
        $userWithEmail = User::factory()->create();

        // Define an array of test cases
        $testCases = [
            [
                'data' => [
                    'name' => '',
                    'email' => 'test@mail.com',
                    'password' => 'password',
                ],
                'expected_error_in' => 'name',
            ],
            [
                'data' => [
                    'name' => 'a',
                    'email' => 'test@mail.com',
                    'password' => 'password',
                ],
                'expected_error_in' => 'name',
            ],
            [
                'data' => [
                    'name' => 2222,
                    'email' => 'test@mail.com',
                    'password' => 'password',
                ],
                'expected_error_in' => 'name',
            ],
            [
                'data' => [
                    'name' => Str::random(31),
                    'email' => 'test@mail.com',
                    'password' => 'password',
                ],
                'expected_error_in' => 'name',
            ],
            [
                'data' => [
                    'name' => 'Name',
                    'email' => '',
                    'password' => 'password',
                ],
                'expected_error_in' => 'email',
            ],
            [
                'data' => [
                    'name' => 'Name',
                    'email' => 'wrong format',
                    'password' => 'password',
                ],
                'expected_error_in' => 'email',
            ],
            [
                'data' => [
                    'name' => 'Name',
                    'email' => $userWithEmail->email,
                    'password' => 'password',
                ],
                'expected_error_in' => 'email',
            ],
            [
                'data' => [
                    'name' => 'Name',
                    'email' => 'test@mail.com',
                    'password' => '',
                ],
                'expected_error_in' => 'password',
            ],
            [
                'data' => [
                    'name' => 'Name',
                    'email' => 'test@mail.com',
                    'password' => Str::random(5),
                ],
                'expected_error_in' => 'password',
            ],
            [
                'data' => [
                    'name' => 'Name',
                    'email' => 'test@mail.com',
                    'password' => Str::random(101),
                ],
                'expected_error_in' => 'password',
            ],
        ];

        // Iterate over each test case and perform the assertions
        collect($testCases)->each(function (array $case) {
            $response = $this->post(route('sign-up'), $case['data']);

            // Assert that the expected error exists in the session
            $response->assertSessionHasErrorsIn($case['expected_error_in']);

            // Assert that the response is a redirect
            $response->assertRedirect();

            // Assert that the user is a guest
            $this->assertGuest();
        });
    }

    /**
     * Test that an authenticated user cannot be handled.
     */
    public function test_authenticated_cant_handle(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a POST request to the sign-up route
        $response = $this->actingAs($user)->post(route('sign-up'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }
}
