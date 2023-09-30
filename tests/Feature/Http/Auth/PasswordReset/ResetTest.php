<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Auth\PasswordReset;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the view for password reset page.
     */
    public function test_view(): void
    {
        // Send a GET request to the password reset route
        $response = $this->get(route('password.reset'));

        // Assert that the response has a status code of 200 (OK)
        $response->assertOk();

        // Assert that the response contains these texts in order
        $response->assertSeeTextInOrder([
            __('auth.password_reset.send_link.title'),
            __('auth.password_reset.reset.description'),
            __('auth.password_reset.reset.update'),
        ]);
    }

    /**
     * Test that an authenticated user cannot view the password reset page.
     */
    public function test_authenticated_cant_view(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a GET request to the password.reset route
        $response = $this->actingAs($user)->get(route('password.reset'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }

    /**
     * Test the handle method of the PasswordResetController.
     *
     * This test verifies that the password reset functionality works correctly.
     */
    public function test_handle(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Generate a password reset token for the user
        $token = Password::createToken($user);

        // Send a POST request to the password reset handle route with the token, email, and new password
        $response = $this->post(route('password.reset.handle'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new password',
        ]);

        // Assert that the response redirects to the sign-in route
        $response->assertRedirectToRoute('sign-in');

        // Assert that the success message is stored in the session
        $response->assertSessionHas('success', __('passwords.reset'));

        // Query the database to get the updated user and perform assertions on the password
        tap(User::query()->first(), function (User $user) {
            $this->assertTrue(Hash::check('new password', $user->password));
        });
    }

    /**
     * Test the handling of failed password reset due to wrong token.
     */
    public function test_handle_failed_by_wrong_token(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Make a POST request to the password reset handle route with wrong token, user email, and new password
        $response = $this->post(route('password.reset.handle'), [
            'token' => 'wrong',
            'email' => $user->email,
            'password' => 'new password',
        ]);

        // Assert that the response is a redirect
        $response->assertRedirect();

        // Assert that there are errors in the 'token' session
        $response->assertSessionHasErrorsIn('token');

        // Retrieve the first user from the database and perform assertions
        tap(User::query()->first(), function (User $user) {
            // Assert that the password is still the same
            $this->assertTrue(Hash::check('password', $user->password));
        });
    }

    /**
     * Test case for handling failed password reset by wrong email.
     */
    public function test_handle_failed_by_wrong_email(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Generate a password reset token for the user
        $token = Password::createToken($user);

        // Send a POST request to the password reset handle route with incorrect email
        $response = $this->post(route('password.reset.handle'), [
            'token' => $token,
            'email' => 'wrong@mail.com',
            'password' => 'new password',
        ]);

        // Assert that the response redirects
        $response->assertRedirect();

        // Assert that the response contains errors in the 'token' field
        $response->assertSessionHasErrorsIn('token');

        // Assert that the user's password remains unchanged
        tap(User::query()->first(), function (User $user) {
            $this->assertTrue(Hash::check('password', $user->password));
        });
    }

    /**
     * Test handle validations.
     *
     * Runs a series of validation tests on different data sets.
     */
    public function test_handle_validations(): void
    {
        collect([
            [
                'data' => [
                    'token' => '',
                    'email' => 'mail@example.com',
                    'password' => 'password',
                ],
                'errors_in' => 'token',
            ], [
                'data' => [
                    'token' => 'token',
                    'email' => '',
                    'password' => 'password',
                ],
                'errors_in' => 'email',
            ], [
                'data' => [
                    'token' => 'token',
                    'email' => 'wrong format',
                    'password' => 'password',
                ],
                'errors_in' => 'email',
            ], [
                'data' => [
                    'token' => 'token',
                    'email' => 'test@mail.com',
                    'password' => '',
                ],
                'errors_in' => 'password',
            ], [
                'data' => [
                    'token' => 'token',
                    'email' => 'test@mail.com',
                    'password' => Str::random(5),
                ],
                'errors_in' => 'password',
            ], [
                'data' => [
                    'token' => 'token',
                    'email' => 'test@mail.com',
                    'password' => Str::random(101),
                ],
                'errors_in' => 'password',
            ],
        ])->each(function (array $case) {
            $response = $this->post(route('password.reset.handle'), $case['data']);

            $response->assertSessionHasErrorsIn($case['errors_in']);
            $response->assertRedirect();
        });
    }

    /**
     * Test that an authenticated user cannot post to the password reset page.
     */
    public function test_authenticated_cant_handle(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a POST request to the password.reset.handle route
        $response = $this->actingAs($user)->post(route('password.reset.handle'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }
}
