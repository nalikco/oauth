<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Auth;

use App\Exceptions\Auth\PasswordReset\PasswordResetException;
use App\Exceptions\Auth\PasswordReset\PasswordResetLinkNotSentException;
use App\Models\User;
use App\Services\Auth\PasswordResetService;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the sendLink method of the PasswordResetService class sends the password reset link correctly.
     *
     * @throws PasswordResetLinkNotSentException if the password reset link is not sent
     */
    public function test_send_link(): void
    {
        // Create an instance of the PasswordResetService class
        $service = $this->app->make(PasswordResetService::class);

        // Create a new user
        $user = User::factory()->create();

        // Fake the notifications
        Notification::fake();

        // Call the sendLink method of the PasswordResetService class with the user's email
        $service->sendLink($user->email);

        // Assert that the password reset token is stored in the database
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);

        // Assert that the ResetPassword notification is sent to the user
        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * Test case to verify that sending a link with an invalid email fails and no password reset token is created.
     */
    public function test_send_link_with_invalid_email(): void
    {
        // Create an instance of the PasswordResetService class
        $service = $this->app->make(PasswordResetService::class);

        // Create a user
        $user = User::factory()->create();

        // Fake notifications
        Notification::fake();

        try {
            // Attempt to send a password reset link with an invalid email
            $service->sendLink('invalid');
        } catch (PasswordResetLinkNotSentException $e) {
            // Verify that the exception message is correct
            $this->assertEquals(__('passwords.user'), $e->getMessage());
        }

        // Verify that no password reset token is created for the invalid email
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);

        // Verify that no reset password notification is sent to the user
        Notification::assertNotSentTo($user, ResetPassword::class);
    }

    /**
     * Test the reset functionality of the PasswordResetService class.
     *
     * @throws PasswordResetException
     */
    public function test_reset(): void
    {
        // Create an instance of the PasswordResetService class
        $service = $this->app->make(PasswordResetService::class);

        // Create a new user
        $user = User::factory()->create();

        // Generate a password reset token for the user
        $token = Password::createToken($user);

        // Reset the user's password using the token
        $service->reset($token, $user->email, 'new password');

        // Assert that the user's password has been updated
        tap(User::query()->first(), function (User $user) {
            $this->assertTrue(Hash::check('new password', $user->password));
        });
    }

    /**
     * Test for the reset_failed method.
     */
    public function test_reset_failed(): void
    {
        // Create an instance of the PasswordResetService class
        $service = $this->app->make(PasswordResetService::class);

        // Create a new user
        $user = User::factory()->create();

        // Generate a password reset token for the user
        $token = Password::createToken($user);

        // Test different cases for resetting the password
        collect([
            [
                'token' => 'wrong',
                'email' => $user->email,
                'expected_message' => __('passwords.token'),
            ], [
                'token' => $token,
                'email' => 'wrong',
                'expected_message' => __('passwords.user'),
            ],
        ])->each(function (array $case) use ($user, $service) {
            try {
                // Attempt to reset the password
                $service->reset($case['token'], $case['email'], 'new password');
            } catch (PasswordResetException $e) {
                // Assert that the correct exception message is thrown
                $this->assertEquals($case['expected_message'], $e->getMessage());
            }

            // Verify that the user's password remains unchanged
            tap(User::query()->first(), function (User $user) {
                $this->assertTrue(Hash::check('password', $user->password));
            });
        });
    }
}
