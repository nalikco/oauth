<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Auth\PasswordReset;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendLinkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the view for sending password reset link.
     */
    public function test_view(): void
    {
        // Send GET request to the 'password.send-link' route
        $response = $this->get(route('password.send-link'));

        // Assert that the response has a status code of 200 (OK)
        $response->assertOk();

        // Assert that the response contains the specified texts in order
        $response->assertSeeTextInOrder([
            __('auth.password_reset.send_link.title'),
            __('auth.password_reset.send_link.description'),
            __('auth.password_reset.send_link.send_link'),
        ]);
    }

    /**
     * Test that an authenticated user cannot view the password reset send link page.
     */
    public function test_authenticated_cant_view(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a GET request to the password.send-link route
        $response = $this->actingAs($user)->get(route('password.send-link'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }

    /**
     * Test the handle function of the class.
     *
     * This function creates a new user, fakes the notification, sends a password reset link,
     * and asserts that the response is redirected to the password.send-link route.
     * It also asserts that a password reset notification is sent to the user.
     */
    public function test_handle(): void
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Fake the notification
        Notification::fake();

        // Send a password reset link by making a POST request to the password.send-link route
        $response = $this->post(route('password.send-link'), [
            'email' => $user->email,
        ]);

        // Assert that the response is redirected
        $response->assertRedirect();

        // Assert that the success message is stored in the session
        $response->assertSessionHas('success', __('passwords.sent'));

        // Assert that a password reset notification is sent to the user
        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * Test the handle_failed method.
     */
    public function test_handle_failed(): void
    {
        // Create a User instance using the factory
        $user = User::factory()->create();

        // Disable notifications for testing purposes
        Notification::fake();

        // Send a POST request to the password send-link route with a wrong email
        $response = $this->post(route('password.send-link'), [
            'email' => 'wrong@mail.com',
        ]);

        // Assert that there are errors in the 'email' field of the session
        $response->assertSessionHasErrorsIn('email');

        // Assert that the response is redirected
        $response->assertRedirect();

        // Assert that a ResetPassword notification is not sent to the user
        Notification::assertNotSentTo($user, ResetPassword::class);
    }

    /**
     * Test function to handle validations.
     */
    public function test_handle_validations(): void
    {
        // Array of test cases
        $testCases = [
            [
                'email' => '',
            ],
            [
                'email' => 'wrong format',
            ],
        ];

        // Iterate over each test case
        foreach ($testCases as $case) {
            // Send POST request to password.send-link route with email parameter
            $response = $this->post(route('password.send-link'), [
                'email' => $case['email'],
            ]);

            // Assert that there are errors in the 'email' session
            $response->assertSessionHasErrorsIn('email');

            // Assert that the response is a redirect
            $response->assertRedirect();
        }
    }

    /**
     * Test that an authenticated user cannot POST to the password reset send link page.
     */
    public function test_authenticated_cant_handle(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Act as the user and send a POST request to the password.send-link.handle route
        $response = $this->actingAs($user)->post(route('password.send-link.handle'));

        // Verify that the response is redirected to the dashboard route
        $response->assertRedirectToRoute('dashboard');
    }
}
