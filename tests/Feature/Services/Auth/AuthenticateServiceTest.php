<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Auth;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Services\Auth\AuthenticateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticateServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the authenticate method of the AuthenticateService class.
     */
    public function test_authenticate(): void
    {
        // Create an instance of the AuthenticateService class using the app container.
        $service = $this->app->make(AuthenticateService::class);

        // Create a new user using the User factory.
        $user = User::factory()->create();

        // Call the authenticate method of the service and pass the user as an argument.
        $service->authenticate($user);

        // Assert that the user is authenticated.
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test the authentication process using user credentials.
     *
     * @throws UnauthorizedException if authentication fails.
     */
    public function test_authenticate_via_credentials(): void
    {
        // Instantiate the AuthenticateService.
        $service = $this->app->make(AuthenticateService::class);

        // Create a new user.
        $user = User::factory()->create();

        // Authenticate the user via credentials.
        $service->authenticateViaCredentials($user->email, 'password');

        // Assert that the user is authenticated.
        $this->assertAuthenticated();
    }

    /**
     * Test case for the 'authenticateViaCredentials' method of the class.
     *
     * This test case checks if the authentication fails when using invalid credentials.
     */
    public function test_authenticate_via_credentials_failed(): void
    {
        // Instantiate the AuthenticateService class
        $service = $this->app->make(AuthenticateService::class);

        // Create a new user using the User factory
        $user = User::factory()->create();

        // Define an array of test cases, each containing an email and password combination
        $testCases = [
            [
                'email' => $user->email,
                'password' => 'wrong',
            ],
            [
                'email' => 'wrong',
                'password' => 'password',
            ],
        ];

        // Loop through each test case and assert that an UnauthorizedException is thrown
        foreach ($testCases as $case) {
            try {
                $service->authenticateViaCredentials($case['email'], $case['password']);
            } catch (UnauthorizedException $exception) {
                $this->assertEquals('', $exception->getMessage());
                $this->assertGuest();
            }
        }
    }

    /**
     * Test the sign-out functionality.
     */
    public function test_sign_out(): void
    {
        // Create an instance of the AuthenticateService class
        $service = $this->app->make(AuthenticateService::class);

        // Create a new user using the User factory
        $user = User::factory()->create();

        // Log in the user using the auth() helper function
        auth()->login($user);

        // Assert that the user is authenticated
        $this->assertAuthenticatedAs($user);

        // Call the signOut() method of the AuthenticateService class
        $service->signOut();

        // Assert that the user is now a guest
        $this->assertGuest();
    }
}
